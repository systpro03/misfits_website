# MISFITS RIDERS — Motorcycle Club Website

A full CodeIgniter 3 (PHP + MySQL) website for a motorcycle riding group, built for **InfinityFree** shared hosting. It ships with:

- A public site — hero, vision/mission, upcoming & past group rides, ride detail pages with routes, team roster, photo gallery, and a "submit a photo" form for visitors.
- An admin panel (`/admin`) — full CRUD for rides, routes, members, and gallery photos, plus a photo-approval queue and site-wide settings (logo, vision/mission, socials).
- A ready-to-import MySQL schema with sample data.
- Tailwind CSS (via CDN, no build step needed) for the UI.

---

## 1. What's in the folder

```
/application      → CodeIgniter app code (controllers, models, views, config)
/system            → CodeIgniter 3 framework core (do not edit)
/assets            → CSS, logo/emblem, and all uploaded images
/database          → misfits_riders.sql — import this into MySQL
index.php          → CI3 front controller
.htaccess          → pretty URLs (removes index.php from links)
```

## 2. Deploying to InfinityFree

1. **Create your hosting account & database**
   - Sign up / log in at InfinityFree and create a new hosting account.
   - In the control panel, go to **MySQL Databases** and create a database. Note the **hostname**, **database name**, **username**, and **password** it gives you (host is usually something like `sqlXXX.infinityfree.com`, and the DB/user names are usually prefixed like `epiz_12345678_misfits`).

2. **Upload the files**
   - Using the File Manager (or FTP with FileZilla), upload **everything inside this folder** into `htdocs/` on your hosting account (so `index.php` sits directly inside `htdocs/`, not inside a subfolder).
   - Make sure hidden files are uploaded too — `.htaccess` files in the root, `application/`, `system/`, `database/`, and `assets/uploads/` all matter for security and routing.

3. **Import the database**
   - Open **phpMyAdmin** from the InfinityFree control panel.
   - Select your database, go to **Import**, and upload `database/misfits_riders.sql`.
   - This creates every table and adds: a default admin login, starter site settings, three sample members, and one sample upcoming + one sample past ride with a route.

4. **Connect the app to your database**
   - Edit `application/config/database.php` and fill in the four values from step 1:
     ```php
     'hostname' => 'sqlXXX.infinityfree.com',
     'username' => 'epiz_XXXXXXXX_misfits',
     'password' => 'your_db_password',
     'database' => 'epiz_XXXXXXXX_misfits',
     ```

5. **Set your live URL**
   - Edit `application/config/config.php` and set:
     ```php
     $config['base_url'] = 'https://yourdomain.infinityfreeapp.com/';
     ```
   - (CodeIgniter can usually auto-detect this, but setting it explicitly avoids issues with redirects and asset paths on some shared-hosting setups.)

6. **Check folder permissions**
   - `application/cache/`, `application/logs/`, and every folder under `assets/uploads/` need to be writable (`755` or `777` depending on how InfinityFree's file manager labels it) so the admin panel can save uploaded photos.

7. **Log in**
   - Visit `https://yourdomain.infinityfreeapp.com/admin`
   - Default login: **admin** / **Misfits2026!**
   - Go to **Site Settings → Change Password** immediately and set your own password.

That's it — the public site is live at your domain, and `/admin` is the control panel.

---

## 3. Using the admin panel

| Section | What it does |
|---|---|
| **Dashboard** | Quick counts (upcoming rides, members, gallery photos) and pending photo requests. |
| **Rides** | Add/edit/delete rides. Mark each as *Upcoming* or *Past*, with a date, meeting point, description, and cover photo. |
| **Routes** | Create a route (start/end point, stops, distance, difficulty, map link, route image) and optionally attach it to a ride — it then shows on that ride's public detail page. |
| **Members** | Add/edit/delete team members: name, road name, position (President, Road Captain, etc.), bike, bio, photo, and display order. |
| **Gallery** | Upload photos directly to the public gallery. |
| **Photo Requests** | Visitors can submit a photo through the public **Gallery** page. Approving a request publishes it straight to the gallery; rejecting it (with an optional note) keeps it off the site. |
| **Site Settings** | Club name, tagline, about text, vision, mission, logo, hero image, contact info, and social links — all editable without touching code. |

Every list screen has **Edit** and **Delete** actions, and deleting a record also removes its uploaded image from the server.

---

## 4. Database structure (summary)

- `admins` — admin accounts (bcrypt-hashed passwords).
- `site_settings` — single-row table holding club name, tagline, about/vision/mission text, logo, hero image, and contact/social links.
- `members` — team roster (name, road name, position, bike, bio, photo, status).
- `rides` — upcoming and past rides (title, description, date/time, meeting point, cover image, optional linked route).
- `routes` — route details (start/end, waypoints, distance, difficulty, map link, image), optionally linked to a ride.
- `gallery` — public photos, tagged with their source (admin upload or an approved visitor request).
- `image_requests` — visitor photo submissions awaiting admin approval (pending / approved / rejected).

Full column definitions, foreign keys, and comments are in `database/misfits_riders.sql`.

---

## 5. Local development (optional)

If you want to test locally before uploading, use XAMPP/MAMP/Laragon:

1. Copy this whole folder into `htdocs/misfits-riders`.
2. Create a MySQL database and import `database/misfits_riders.sql`.
3. Update `application/config/database.php` with your local MySQL credentials (usually `hostname: localhost`, `username: root`, `password: ''`).
4. Leave `base_url` blank in `config.php` — it will auto-detect `http://localhost/misfits-riders/`.
5. Visit `http://localhost/misfits-riders/` and `http://localhost/misfits-riders/admin`.

---

## 6. Notes & next steps

- **Change the default admin password** right after your first login.
- **Change `encryption_key`** in `application/config/config.php` to a long random string before going live.
- The Tailwind styling loads from the CDN (`cdn.tailwindcss.com`) — no Node/npm build step is needed, which keeps this compatible with InfinityFree's PHP-only hosting.
- Uploaded images are stored under `assets/uploads/` (not in the database) — the database only stores the filename. A `.htaccess` in that folder blocks PHP execution for security.
- CSRF protection is left off by default (`$config['csrf_protection'] = FALSE;`) to keep the multi-form admin pages simple. You can turn it on in `application/config/config.php` once you're comfortable adding the hidden CSRF field to every form.
