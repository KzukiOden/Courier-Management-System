# 📦 Courier Tracking System (Full Stack Web Application)

A simple yet powerful **Courier Tracking System** built using **Core PHP, MySQL, HTML5, CSS3, JavaScript**, and **Bootstrap 5**.

This project demonstrates full-stack web development concepts including:
- User authentication with roles (Admin/User)
- CRUD operations for courier management
- Responsive UI design
- Form validation (client + server side)
- Database integration

---

## 🧾 Features

### 🔐 Authentication
- Admin and User login system using PHP sessions
- Role-based access control
- Secure password handling using `password_hash()` and `password_verify()`

### 📦 Admin Module
- Add new courier records
- View, edit, and delete existing couriers
- Filter couriers by status
- Dashboard with statistics (total, pending, delivered, etc.)

### 📦 User Module
- Track courier by tracking ID
- Search by sender name, receiver name, or date range
- Clean and responsive layout

### 🎨 UI/UX
- Bootstrap 5 for responsive design
- Custom CSS styling
- Modern card-based layout

---

## 🧰 Technologies Used

| Technology | Description |
|----------|-------------|
| **PHP** | Core PHP (no frameworks) for backend logic |
| **MySQL** | For database storage |
| **HTML5 / CSS3** | Semantic structure and custom styling |
| **JavaScript** | Client-side interactivity and form validation |
| **Bootstrap 5** | Responsive design components |
| **XAMPP/WAMP** | Local development environment |

---

## 🗂️ Folder Structure
courier-tracking-system/
│
├── assets/ # Static assets
│ ├── css/ # Custom CSS files
│ │ └── style.css # Main stylesheet
│ ├── js/ # JavaScript files
│ │ └── main.js # Custom JS for interactivity
│ └── images/ # Images used in the project
│ └── logo.png
│
├── includes/ # Reusable PHP components
│ ├── header.php # Header with navbar and session check
│ ├── footer.php # Footer with scripts
│ └── db.php # Database connection file
│
├── admin/ # Admin-specific pages
│ ├── dashboard.php # Admin homepage
│ ├── add_courier.php # Add new courier
│ ├── manage_couriers.php # View/edit/delete couriers
│
├── user/ # User-specific pages
│ ├── dashboard.php # User homepage
│ └── track.php # Track courier by ID
│
├── auth/ # Authentication-related files
│ ├── login.php # Login form
│ ├── logout.php # Logout script
│ └── auth.php # Login processing script
│
├── database.sql # Exported SQL schema and sample data
├── index.php # Landing page or redirect to login
└── README.md # This file

---

## ✅ Next Steps (Optional)

If you're uploading this to GitHub:
- Create a new repo: `courier-tracking-system`
- Push all files
- Paste this `README.md` content
- Add screenshots (optional) under `assets/images/`

---

Would you like me to generate a `.gitignore` file too?

Or would you like help creating a **video demo script** or **presentation slides**?

Just say:
- `"Yes, give me .gitignore"`
- `"Yes, I need presentation help"`

I’ll help you finish everything 👇