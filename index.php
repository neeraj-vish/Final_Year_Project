
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Home-page.css">
    <title>IT-Marvels</title>
    <style>
       

        /* CSS for login overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .login-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
            color: red;
            font-size: 15px;
        }

        .welcome-message {
            color: blue;
            font-size: 15px;
            margin: 0;
            padding: 0;
            line-height: normal;
            background-color: transparent;
        }
    </style>
</head>

<body>
    <?php
    include('heading.php');

    ?>

 

    <div class="overlay" id="loginOverlay">
        <div class="login-box">
            <?php include('logintype.php'); ?> <!-- Include logintype.php here -->
        </div>
    </div>

    <div class="main-body">
        <span class="img">
            <img src="https://www.shutterstock.com/image-photo/business-team-members-standing-over-600nw-1397307989.jpg" class="img1">
        </span>
        <span class="img">
            <img src="https://www.bobsearch.com/wp-content/uploads/2017/06/10-29_company_culture.jpg" class="img2">
        </span>

        <hr style="margin-top: 35px; border: 2px dotted black;">
        <div class="Service">
            <h1>Our Services</h1>
        </div>
        <div class="slider-container">
            <div class="inner-container">
                <div class="slide">
                    <img src="https://smallbusiness-staging.s3.amazonaws.com/uploads/2021/12/Web-designer-scaled-1.jpg" alt="Slide 1">
                </div>
                <div class="slide">
                    <img src="https://blog.webhopers.com/wp-content/uploads/2022/03/Top-Mobile-App-Development-Companies-in-Chennai-1.png" alt="Slide 2">
                </div>
                <div class="slide">
                    <img src="https://okcredit-blog-images-prod.storage.googleapis.com/2021/03/Software-Development-Business1--1-.jpg" alt="Slide 3">
                </div>
                <div class="slide">
                    <img src="https://images.shiksha.com/mediadata/shikshaOnline/mailers/2021/naukri-learning/nov/11nov/what-is-SEO.jpg" alt="Slide 4">
                </div>
            </div>
            <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
            <a class="next" onclick="changeSlide(1)">&#10095;</a>
        </div>
        <div class="column-container">
            <div class="detail-info">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fd/Eo_circle_blue_number-1.svg/1024px-Eo_circle_blue_number-1.svg.png" alt="">
                <h1>Business Web Design</h1>
                <p>Web design is similar to being the architect and artist of a website. It's about choosing how the site appears, where items belong, and making sure it's simple to use. A excellent website, like a well-designed building, is both appealing and functional.</p>
            </div>
            <div class="detail-info">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTjO9Ao012EceE0P7o-SOA6nzuRoU0wDPyXG-MF4aY0fgT1emov66f5kDbDfLrc2cUiY7U&usqp=CAU" alt="">
                <h1>Mobile Application</h1>
                <p>A mobile application (also called a mobile app) is a type of application designed to run on a mobile device, which can be a smartphone or tablet computer,most commonly for the Android and iOS operating systems.</p>
            </div>
            <div class="detail-info">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Eo_circle_blue_number-3.svg/2048px-Eo_circle_blue_number-3.svg.png" alt="">
                <h1>Software Development</h1>
                <p>Software development is the process of designing, creating, testing, and maintaining different software applications. It involves the application of various principles and techniques from computer science, engineering and mathematical analysis. Software development aims to create efficient, reliable, and easy-to-use software.</p>
            </div>
            <div class="detail-info">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/45/Eo_circle_blue_number-4.svg/800px-Eo_circle_blue_number-4.svg.png" alt="">
                <h1>S/W Engine Optimization</h1>
                <p>SEO is a set of processes aimed at improving a website’s visibility in search engines, like Google, with the goal of getting more organic traffic. SEO is about fulfilling users’ search needs by creating relevant, high-quality content and providing the best possible user experience.</p>
            </div>
        </div>

        <hr style="margin-top: 35px; border: 2px dotted black;">
        <div class="footer" style="height: 150px;">
            <div class="inner-footer">
                <h2>Service</h2>
                <ul type="circle">
                    <li>Website Development</li>
                    <li>Mobile Development</li>
                    <li>Software Development</li>
                    <li>SEO(Software Engine Optimization)</li>
                </ul>
            </div>
            <div class="inner-footer">
                <h2>Product</h2>
                <ul type="circle">
                    <li>OMR (Optical Mark Reader)</li>
                    <li>Mobile Exam (Android App)</li>
                    <li>Online Exam (Desktop version)</li>
                    <li>Traders Delight</li>
                </ul>
            </div>
            <div class="inner-footer">
                <h2>Contact Us</h2>
                <ul type="circle">
                    <li>Email: info@it-marvels.com</li>
                    <li>Phone: 020-24484075</li>
                    <li>Flat No.4, B-Wing, Suyash Appt.,Near Sharmilee Showroom, Phadtare Chowk, 769 Sadashiv Peth, Pune-411030.</li>
                </ul>
            </div>
        </div>

        <p style="background-color: black; color: brown; height: 30px; padding: 12px;">&copy;IT Marvel-Created By Neeraj & Gaurav.&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://it-marvels.com/">www.it-marvels.com</a></p>
        <hr style=" border: 2px dotted black;">
    </div>
    <script src="Home-page.js"></script>
    

</body>

</html>

