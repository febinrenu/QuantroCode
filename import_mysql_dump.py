import re
import sys
import sqlite3

def convert_and_import(mysql_dump_path, sqlite_db_path):
    print(f"Importing {mysql_dump_path} into {sqlite_db_path}...")
    
    with open(mysql_dump_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Split the file by ;\n
    statements = content.split(';\n')
    insert_statements = [s.strip() for s in statements if s.strip().startswith('INSERT INTO')]
    
    print(f"Found {len(insert_statements)} INSERT statements. Adjusting syntax...")
    
    # Connect to SQLite
    conn = sqlite3.connect(sqlite_db_path)
    cur = conn.cursor()
    cur.execute("PRAGMA foreign_keys=OFF;")
    
    success_count = 0
    error_count = 0
    
    for stmt in insert_statements:
        stmt_adj = stmt.replace("\\'", "''")
        stmt_adj = stmt_adj.replace('\\"', '"')
        # MySQL uses \r\n explicitly in strings sometimes, let's substitute them safely:
        stmt_adj = stmt_adj.replace('\\r\\n', '\r\n')
        stmt_adj = stmt_adj.replace('\\n', '\n')
        
        try:
            cur.execute(stmt_adj)
            success_count += 1
        except Exception as e:
            if error_count < 3:
                print(f"Failed to insert: {e}\nStatement preview: {stmt_adj[:200]}...")
            error_count += 1

    conn.commit()
    conn.close()
    
    print(f"Import complete! {success_count} succeeded, {error_count} failed.\n")

if __name__ == "__main__":
    convert_and_import('quantrocousr_dbx7.sql', 'database/database.sqlite')
    convert_and_import('quantrocousr_db3.sql', 'database/tenantdemo.sqlite')
