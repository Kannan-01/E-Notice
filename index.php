<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>E-Notice</title>
    <link rel="icon" type="image/x-icon" href="../noti.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            background: #f9fafc;
            color: #2d2e32;
        }

        /* Hero */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fff8e5, #f0f4ff);
            text-align: center;
            padding: 40px 20px;
        }

        .hero h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero .accent {
            color: #f8b739;
        }

        .hero p {
            font-size: 1.2rem;
            color: #555;
            max-width: 600px;
            margin: 0 auto 30px;
        }

        .btn-main {
            background: #f8b739;
            border: none;
            color: #222;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 12px;
            transition: 0.2s;
        }

        .btn-main:hover {
            background: #cfa205;
            color: #fff;
        }

        .btn-outline-main {
            border: 2px solid #f8b739;
            color: #f8b739;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 12px;
            background: #fff;
            transition: 0.2s;
        }

        .btn-outline-main:hover {
            background: #f8b739;
            color: #fff;
        }

        footer {
            padding: 18px;
            text-align: center;
            background: #202235;
            color: #aaa;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero">
        <div>
            <h1>Welcome to <span class="accent">E-Notice</span></h1>
            <p>
                A digital notice board system for colleges and universities.
                Stay updated with important announcements, exam schedules, and events — anytime, anywhere.
            </p>
            <div class="d-flex gap-3 justify-content-center mt-4">
                <a href="./auth/signup.php" class="btn text-white px-4 py-2 rounded-3"
                    style="background:#f8b739;">Sign Up</a>

                <a href="./auth/login.php" class="btn text-white px-4 py-2 rounded-3"
                    style="background:#202235;">Login</a>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        © 2025 E-Notice | Connecting Students & Teachers Digitally
    </footer>
</body>

</html>