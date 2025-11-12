Portfolio - Complete PHP-enabled Website
=========================================

Contents:
- index.html          -> Main site with Home, About, Projects, Certifications, Experience, Contact
- css/style.css       -> Styles (dark futuristic)
- js/script.js        -> Smooth scrolling, nav toggle, AJAX contact submit
- submit.php          -> PHP backend to validate + save submissions as .txt files
- /submissions/       -> Automatically created when first submission is received

Notes:
- The header includes placeholder name/title; it's intentionally left blank for you to fill.
- To deploy: upload entire folder contents to your PHP-enabled host (public_html or similar).
- Ensure the server process user can create/write to the 'submissions' directory (permissions 755 or 775 typically).
- CAPTCHA is a simple math check (3 + 4 = 7) — for stronger protection consider Google reCAPTCHA.

Security suggestions:
- Add CSRF protection and stronger captcha for production.
- Monitor the submissions directory and set retention/backup policies.
- Disable directory listing on the server for the submissions folder.

If you'd like I can:
- Add email notifications on each submission.
- Switch storage to JSON or a database.
- Integrate reCAPTCHA or other anti-spam measures.
