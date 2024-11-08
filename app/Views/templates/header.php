<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= esc($title); ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Join the Açaí Forum to discuss and propose infrastructure development in your city.">
        <meta name="keywords" content="city, development, infrastructure, forum, community">
        <meta name="author" content="Açaí Innovators Team">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS and JS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Poppins -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- Custom CSS -->
        <style>
            body {
                padding: 0;
                font-family: "Poppins", sans-serif;
                margin: 0;
            }

            h1 {
                padding: 2%;
                margin-top: 2%;
                text-align: center;
            }

            nav a {
                color: rgb(33, 37, 41);
                text-decoration: none;
            }

            p {
                font-size: 150%;
            }

            .background-half {
                background-image: url('/images/buildings-rising.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
                animation: slideFadeIn 2s forwards;
                color: white;
                justify-content: center;
                text-align: center;
                z-index: -2;
            }

            .background-half::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(5px);
                z-index: -1;
            }

            .background-half h1 {
                margin: 0;
            }

            @keyframes slideFadeIn {
                0% {
                    opacity: 0;
                    transform: translateX(-10%);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .full-center {
                margin: 0;
                position: relative;
                top: 50%;
                left: 50%;
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            .fade-in-header {
                color: white;
                opacity: 0;
                animation: fadeIn 2s forwards 1s;
            }

            @keyframes fadeIn {
                0% {
                    opacity: 0;
                    transform: translateY(30%);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .fade-in-description {
                opacity: 0;
                animation: fadeIn 2s forwards 1.5s;
            }

            @keyframes fadeIn {
                0% {
                    opacity: 0;
                    transform: translateY(30%);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .login-bg {
                background-image: url('https://i1.adis.ws/i/canon/get-inspired-composition-tips-urban-cityscapes-3_08b0f41598744af6bbc287a6cf6a30ff?$media-collection-half-dt$');
                background-size: cover;
                background-position: fixed;
                background-repeat: no-repeat;
            }

            .search-form input {
                width: 70%;
            }

            .search-form button {
                width: 20%;
            }

            #about-us-intro {
                padding: 0 5%;
            }

            #support-list {
                list-style-type: none;
            }

            #tagline {
                font-size: 150%;
                text-align: center;
            }
        </style>
        <script defer async>
            document.addEventListener("DOMContentLoaded", function() {
                const element = document.querySelector('nav');
                const elementHeight = element.offsetHeight;
                const newHeight = `calc(100vh - ${elementHeight}px)`;
                const backgroundHalf = document.querySelector('.background-half');
                backgroundHalf.style.height = newHeight;
            });
        </script>
    </head>
    <body>