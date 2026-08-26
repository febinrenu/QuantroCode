# Aureum Enterprise - Local Development Setup

Welcome to the team! Follow this guide to set up the Aureum Enterprise (QuantroCode) SaaS platform on your local machine identically to the rest of the team.

---

### Prerequisites
1. **PHP 8.x** installed locally.
2. **Composer** installed.
3. A local MySQL server (like **XAMPP**, **WAMP**, or **Laragon**) running on port **3306**.
   > *Note: Ensure your MySQL instance contains a `root` user with **NO password**, which is the default for XAMPP. The setup scripts will use this to automatically provision the central and tenant databases.*

---

### Step-by-Step Setup

1. **Clone the Repository**
   Make sure you have cloned this repository and are working inside the `QuantroCode18082026` folder.

2. **Start your Local MySQL / XAMPP Server**
   Verify that MySQL is running in your control panel.

3. **Run the Initialization Script**
   Double-click the **`start.bat`** file located in the root directory.

4. **Select First-Time Setup**
   When the prompt asks you to select an option, press **`2`** (`FIRST TIME SETUP: Rebuild Databases from SQL Dumps`).
   
   Behind the scenes, this will automatically:
   - Install all Composer dependencies.
   - Recreate the central database (`quantrocousr_dbx7`) and tenant database (`quantrocousr_db3`).
   - Import the exact SQL dump schemas and data provided by the project lead.
   - Normalize the database connection credentials for all incoming tenants so that the codebase uses your seamless `root` connection.
   - Upgrade the default tenant (`newstock`) to the **Enterprise plan**!

5. **Start the Application**
   Once setup is complete, the server will automatically begin running at **http://localhost:8000**.
   *(In the future, you can just press `1` when opening `start.bat` to bypass the installation logic.)*

---

### Key Credentials

**Central Dashboard** (`http://localhost:8000`)
If you need to login to the central module, run `start.bat` and press **`3`** to instantly seed the superadmin account.
* **Email:** `superadmin@stockysaas.site`
* **Password:** `123456`

**Tenant Dashboard: NewStock** (`http://newstock.localhost:8000`)
* **Email:** `railcoder@gmail.com`
* **Password:** `123456`

---

### ⚠️ A Note on Premium Modules (Online Store / HRM)
If you do not see the **Online Store** (Ecommerce) feature on the sidebar after logging in, this is expected behavior for a fresh codebase. Premium modules are distinct `.zip` files hosted outside the generic repository.
To unlock them:
1. Obtain the `Ecommerce.zip` (or other addon zip files).
2. Go to `Settings -> Module Settings` in the dashboard.
3. Upload the `.zip` file into the module manager. The system will enable it automatically.
