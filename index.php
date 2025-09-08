<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>E-Notice - Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background: #f5f6fd;
            margin: 0;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        }


        .landing-container {
            width: 100vw;
            height: 100vh;
            max-width: none;
            margin: 0;
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            background: #fff;
            border-radius: 0;
            box-shadow: none;
            padding: 60px 80px;
            box-sizing: border-box;
        }

        .landing-content {
            flex: 1 1 440px;
            min-width: 280px;
        }

        .brand-title {
            font-size: 2rem;
            font-weight: 700;
            color: #f8b739;
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            margin-bottom: 16px;
            font-size: 1.08rem;
        }

        .nav-links a {
            color: #888ab3;
            text-decoration: none;
            font-weight: 500;
            transition: color .2s;
        }

        .nav-links a.active,
        .nav-links a:hover {
            color: #f8b739;
        }

        .main-title {
            font-size: 2.3rem;
            font-weight: 700;
            margin-top: 30px;
            color: #202235;
            line-height: 1.24;
        }

        .main-title .accent {
            color: #f8b739;
        }

        .main-desc {
            font-size: 1.16rem;
            color: #657089;
            margin-top: 18px;
            margin-bottom: 33px;
            max-width: 420px;
        }

        .landing-actions {
            display: flex;
            gap: 18px;
            margin-bottom: 28px;
        }

        .btn-landing {
            font-size: 1rem;
            border-radius: 14px;
            padding: 11px 30px;
            font-weight: 600;
            border: none;
            box-shadow: 0 3px 13px rgba(248, 183, 57, 0.14);
            transition: background .2s, color .2s;
        }

        .btn-primary-landing {
            background: #f8b739;
            color: #222;
        }

        .btn-primary-landing:hover {
            background: #cfa205;
            color: white;
        }

        .btn-secondary-landing {
            background: #fff;
            border: 2px solid #f8b739;
            color: #f8b739;
        }

        .btn-secondary-landing:hover {
            background: #f8b739;
            color: white;
        }

        .landing-illustration {
            flex: 1 1 340px;
            min-width: 260px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .illus-bg {
            position: absolute;
            top: 38px;
            left: 25px;
            width: 260px;
            height: 260px;
            z-index: 0;
            background: linear-gradient(135deg, #f8b739 62%, #a077f7 95%);
            border-radius: 34% 66% 53% 47% / 46% 37% 63% 54%;
            opacity: 0.14;
        }

        .illus-img {
            width: 260px;
            z-index: 1;
            border-radius: 14px;
            background: #fff4d1;
            box-shadow: 0 6px 30px rgba(248, 183, 57, 0.10);
        }

        .login-links {
            position: absolute;
            top: 28px;
            right: 38px;
            display: flex;
            gap: 12px;
        }

        .btn-login,
        .btn-signup {
            border-radius: 10px;
            padding: 7px 20px;
            font-size: 1rem;
            font-weight: 500;
            border: none;
            background: #fafaff;
            color: #f8b739;
            box-shadow: 0 2px 7px rgba(248, 183, 57, 0.16);
            transition: background .2s;
        }

        .btn-login:hover,
        .btn-signup:hover {
            background: #f8b739;
            color: #fff;
        }

        @media (max-width: 900px) {
            .landing-container {
                flex-wrap: wrap;
                padding: 40px 30px;
                height: auto;
                min-height: 100vh;
            }
        }

        @media (max-width: 600px) {
            .landing-container {
                min-height: unset;
                padding: 15px 5px;
            }

            .landing-content {
                min-width: 180px;
            }

            .illus-img,
            .illus-bg {
                width: 160px;
                height: 160px;
            }

            .main-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <div class="landing-container">
        <div class="landing-content">
            <div class="brand-title">E<span style="color:#202235;">-Notice</span></div>
            <div class="nav-links">
                <a href="#" class="active">Home</a>
                <a href="#">About</a>
                <a href="#">Category</a>
                <a href="#">Contact</a>
            </div>
            <div class="main-title">
                Free <span class="accent">Notices</span> <br>
                For Every Bright Student & Teacher
            </div>
            <div class="main-desc">
                Get updates for every important event, alert, or opportunity. Instantly deliver notices to every student or teacher, making communication seamless in your educational institution.
            </div>
            <div class="landing-actions">
                <button class="btn-landing btn-primary-landing">Submit Notice</button>
                <button class="btn-landing btn-secondary-landing">View Notices</button>
            </div>
        </div>
        <div class="landing-illustration">
            <div class="illus-bg"></div>
            <!-- Use your own SVG or PNG for illustration; below is a sample SVG avatar for placeholder -->
            <img src="child.png" class="illus-img" alt="Landing Illustration">
            <div class="login-links">
                <button class="btn-login">Login</button>
                <button class="btn-signup">Sign Up</button>
            </div>
        </div>
    </div>
</body>

</html>