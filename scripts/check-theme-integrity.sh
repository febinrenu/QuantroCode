#!/usr/bin/env bash
# Verifies the storefront theme catalog under resources/views/store/themes
# hasn't regressed into the "general theme overwritten by its
# category-specific sibling" bug fixed in PR (restore-general-storefront-themes).
#
# Run this after merging/rebasing onto main, or before opening a PR that
# touches resources/views/store/themes, to catch the same mistake early:
#
#   bash scripts/check-theme-integrity.sh
#
# Exits non-zero and prints details if any pair looks collapsed into a
# near-duplicate, or if the general/category-specific counts drift from
# the expected 20 + 14.

set -eu
cd "$(dirname "$0")/.."

THEMES_DIR="resources/views/store/themes"

# slug pairs: general_theme:category_specific_sibling
PAIRS=(
  "generalhub:generalhub-store"
  "novatech:novatech-electronics"
  "voguelane:voguelane-couture"
  "zanova:zanova-flash"
  "marketverse:marketverse-deals"
  "naturae:naturae-wellness"
  "nexora:nexora-trending"
  "technova:technova-audio"
  "veloura:veloura-beauty"
)

fail=0

echo "Checking general theme vs category-specific sibling divergence..."
for pair in "${PAIRS[@]}"; do
  general="${pair%%:*}"
  sibling="${pair##*:}"
  gfile="$THEMES_DIR/$general/home.blade.php"
  sfile="$THEMES_DIR/$sibling/home.blade.php"

  if [[ ! -f "$gfile" || ! -f "$sfile" ]]; then
    echo "  SKIP $general / $sibling (one of the theme directories is missing)"
    continue
  fi

  diff_lines=$(diff "$gfile" "$sfile" | wc -l)
  total_lines=$(wc -l < "$gfile")
  # If the general theme's home view is almost identical to its
  # category-specific sibling, it has almost certainly been overwritten.
  threshold=$(( total_lines / 10 ))
  if [[ "$diff_lines" -lt "$threshold" ]]; then
    echo "  FAIL: '$general' looks like a near-duplicate of '$sibling' (diff: $diff_lines lines vs ~$total_lines total). It should be its own distinct general-merchandise theme."
    fail=1
  else
    echo "  OK:   $general is distinct from $sibling ($diff_lines diff lines)"
  fi
done

echo
echo "Checking theme category counts..."
general_count=$(grep -l '"category": "general-merchandise"' "$THEMES_DIR"/*/theme.json 2>/dev/null | wc -l)
total_count=$(ls -d "$THEMES_DIR"/*/ 2>/dev/null | wc -l)
category_specific_count=$(( total_count - general_count ))

echo "  Total theme directories: $total_count"
echo "  general-merchandise:     $general_count"
echo "  category-specific/other: $category_specific_count"

if [[ "$general_count" -lt 20 ]]; then
  echo "  FAIL: expected at least 20 general-merchandise themes, found $general_count."
  fail=1
fi

if [[ "$fail" -ne 0 ]]; then
  echo
  echo "Theme integrity check FAILED. See app/Http/Controllers/StoreFrontController.php and"
  echo "resources/views/store/themes/<slug>/theme.json for the affected theme(s)."
  exit 1
fi

echo
echo "Theme integrity check passed."
