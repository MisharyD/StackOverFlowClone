<?php
session_start();
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tags</title>
    <!-- <link rel="stylesheet" href="CSS/test.css"> -->
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">

    <style>
        .subject {
            font-size: 40px;
            font-weight: bold;
            margin: 40px;
        }

        .whole-tags {
            display: grid;
            grid-template-columns: 250px 250px 250px 250px;
            gap: 30px;
            margin-left: 40px;
        }

        .tag-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            border: 1px solid #d2d2d2;
            padding: 20px;
        }

        .tag span {
            background-color: #e1ecf4;
            color: #275577;
            padding: 6px;
            font-size: 20px;
            font-weight: bold;
            border: 1px solid #d2d2d2;
        }

        .tag-description {
            height: 120px;
            overflow-wrap: break-word;
            font-size: 14px;
        }
    </style>

</head>

<body>
    <!-- Header part-->
    <?php

    if (isset($_SESSION["username"])) {
        include "LoggedIn-header.php";
    } else {
        include "notLoggedIn-header.php";
    }

    ?>
    <!-- Body part-->
    <div class="body">
        <div class="container">
            <div class="left-body-container">
                <ul class="tab-container">
                    <li class="tab">
                        <a href="index.php">
                            <img src="images/homeIcon.png" width="20px" height=auto>
                            <div>Home</div>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="userHome.php">
                            <img src="images/user.png" width="20px" height=auto>
                            <div>Profile</div>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="searchHome.php">
                            <img src="images/question.png" width="15px" height=auto>
                            <div> Questions</div>
                        </a>
                    </li>
                    <li class="current-page tab">
                        <a href="tags.html">
                            <img src="images/tag.png" width="20px" height=auto>
                            <div>Tags</div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="middle-body-container">
                <div class="container">
                    <div class="right-side">
                        <div class="subject">Famous Tags Explanation</div>
                        <div class="whole-tags">
                            <div class="tag-container">
                                <div class="tag"><span>javascript</span></div>
                                <div class="tag-description">For questions regarding programming in ECMAScript
                                    (JavaScript/JS) and its various dialects/implementations (excluding ActionScript).
                                    Please include all relevant tags on your question;
                                </div>
                            </div>
                            <div class="tag-container">
                                <div class="tag"><span>python</span></div>
                                <div class="tag-description">Python is a multi-paradigm, dynamically typed, multipurpose
                                    programming language. It is designed to be quick to learn, understand, and use, and
                                    enforces a clean and uniform syntax.</div>
                            </div>
                            <div class="tag-container">
                                <div class="tag"><span>c#</span></div>
                                <div class="tag-description">C# (pronounced 'see sharp') is a high level, statically
                                    typed, multi-paradigm programming language developed by Microsoft</div>
                            </div>
                            <div class="tag-container">
                                <div class="tag"><span>java</span></div>
                                <div class="tag-description">Java is a high-level object oriented programming language.
                                    Use this tag when you're having problems using or understanding the language itself.
                                </div>
                            </div>
                            <div class="tag-container">
                                <div class="tag"><span>php
                                    </span></div>
                                <div class="tag-description">PHP is a widely used, open source, general-purpose,
                                    multi-paradigm, dynamically typed and interpreted scripting language originally
                                    designed for server-side web development</div>
                            </div>
                            <div class="tag-container">
                                <div class="tag"><span>html</span></div>
                                <div class="tag-description">HTML (HyperText Markup Language) is the markup language for
                                    creating web pages and other information to be displayed in a web browser.</div>
                            </div>
                            <div class="tag-container">
                                <div class="tag"><span>android</span></div>
                                <div class="tag-description">Android is Google's mobile operating system, used for
                                    programming or developing digital devices (Smartphones, Tablets, Automobiles, TVs,
                                    Wear, Glass, IoT).</div>
                            </div>
                            <div class="tag-container">
                                <div class="tag"><span>css</span></div>
                                <div class="tag-description">CSS is a representation style sheet language used for
                                    describing the look and formatting of HTML, XML documents and SVG elements including
                                    colors, layout, fonts, and animations</div>
                            </div>
                            <div class="tag-container">
                                <div class="tag"><span>Reactjs</span></div>
                                <div class="tag-description">React is a JavaScript library for building user interfaces.
                                    It uses a declarative, component-based paradigm and aims to be both efficient and
                                    flexible.</div>
                            </div>
                            <div class="tag-container">
                                <div class="tag"><span>node.js</span></div>
                                <div class="tag-description">Node.js is an event-based, non-blocking, asynchronous I/O
                                    runtime that uses Google's V8 JavaScript engine and libuv library.</div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
