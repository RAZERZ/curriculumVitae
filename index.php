<?php

class databaseAuth {

    public function __construct() {
        $this->connection = new mysqli('localhost', 'root', '', 'curriculumVitae');

        if($this->connection->connect_error) {
            die("Connection to database failed: " . $this->connection->connect_error);
        }

        if($query = $this->connect()->prepare("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'")) {
            $query->execute();
        }
    }

    public function connect() {
        return $this->connection;
    }

    public function getValue($table) {

        if($query = $this->connect()->prepare("SELECT * FROM $table;")) {
            $query->execute();
            $result = $query->get_result();
            $resultArr = array();

            while($row = $result->fetch_assoc()) {
                array_push($resultArr, $row);
            }

            $query->close();

            return $resultArr;

        }
    }

}

$mysqli  = new databaseAuth();

$userInfo = $mysqli->getValue("userInfo");
$profile = $mysqli->getValue("profile");
$competences = $mysqli->getValue("competens");
$references = $mysqli->getValue("projreferences");
$jobexperiences = $mysqli->getValue("jobexperience");
$educations = $mysqli->getValue("education");
$projects = $mysqli->getValue("projects");
$languages = $mysqli->getValue("languages");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $userInfo[0]['name'] . ' - CV' ?></title>
</head>

<body>

    <style>
        @page {
            size:auto;
            margin:unset;
        }

        body {
            margin: unset;
            font-family: Calibri;
            print-color-adjust: exact;
        }

        #headerContainer {
            width: 100%;
            height: 250px;
            color: #fff;
            background: #2f383a;
        }
        .nameContainer {
            width: fit-content;
            margin: 0 auto;
            padding: 0.2% 10%;
            text-align: center;
            border: 2px solid #fff;
            transform: translateY(150%);
        }
        .nameContainer span {
            font-size: 3em;
            font-weight: 700;
        }
        .title {
            color: #cfd0d0;
            font-size: 1.4em;
            margin-top: 16%;
            margin-bottom: unset;
            text-align: center;
            text-transform: uppercase;
        }
        #body {
            padding: 0 3%;
        }
        .left {
            margin-top: 3%;
            float: left;
            width: 40%;
        }
        .left div {
            margin: 3% 0;
            padding-bottom: 3%;
            border-bottom: 1px solid grey;
        }
        .right {
            margin-top: 4%;
            float: right;
            width: 53%;
        }
        .jobexperience, .education {
            margin-bottom: 10%;
        }
        .jobexperience:nth-child(4) {
            padding-top: 25%;
            margin-top: 100%;
        }
        #body::after, .left::after, .right::after, .jobexperience::after, .education::after {
            content: "";
            display: block;
            visibility: hidden;
            clear: both;
            line-height: 0;
            height: 0;
        }
        .jobexperience span, .education span {
            color: grey;
        }
        .jobexperience div, .education div {
            width: 80%;
            float: right;
            border-left: 2px solid grey;
        }
        .jobexperience div p, .education div p {
            margin: unset;
            padding-left: 3px;
        }
        .jobexperience div ul {
            margin: unset;
            padding-left: 10%;
            list-style: disc;
        }
        .jobexperience div ul li {
            font-size: 16px;
        }
        .jobexperience div p.titleCompany, .education div p.titleCompany {
            margin-left: 0.35px !important;
            background: #f2f2f2;
            font-weight: bolder;
            font-size: 1.1em;
        }
        .jobexperience div p.location {
            margin-top: 2px;
            font-weight: bolder;
            font-size: 0.97em;
        }
        .jobexperience div p.innerText, .education div p.innerText {
            margin-top: 2px;
            font-size: 0.97em;
        }
        .jobexperience div p.achievements {
            margin-top: 10px;
            font-weight: bolder;
            font-size: 1.1em;
        }
        .competence ul {
            border-left: 2px solid #2f383a;
            padding-left: 4%;
        }
        .competence li {
            text-transform: uppercase;
        }
        .references li {
            font-size: 16px;
        }
        h1 {
            text-transform: uppercase;
            margin-top: unset;
        }
        ul {
            padding: 0;
            font-size: 1.1em;
            list-style: none;
        }
        a {
            color: black;
        }
        #footer {
            position: absolute;
            height: 60px;
            width: 100%;
            background: #2f383a;
            text-align: center;
            color: white;
        }
    </style>

    <div id="headerContainer">
        <div class="nameContainer">
            <span><?php echo $userInfo[0]['name']; ?></span>
        </div>
        <p class="title"><?php echo $userInfo[0]['currTitle']; ?></p>
    </div>

    <div id="body">

        <div class="left">
            <div class="personalInfo">
                <h1>personuppgifter</h1>
                <ul>
                    <li><?php echo $userInfo[0]['address']; ?></li>
                    <li><?php echo $userInfo[0]['city'] . ', ' . $userInfo[0]['postalCode']; ?></li>
                    <li><?php echo $userInfo[0]['phone']; ?></li>
                    <li><a href="mailto:<?php echo $userInfo[0]['mail']; ?>"><?php echo $userInfo[0]['mail']; ?></a></li>
                </ul>
            </div>
            <div class="profile">
                <h1>profil</h1>
                <span><?php echo $profile[0]['innerText']; ?></span>
            </div>
            <div class="competence">
                <h1>kompetens</h1>
                <ul>
                    <?php
                    foreach ($competences as $competence) { ?>
                        <li><?php echo $competence["innerText"]; ?></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="references" style="border-bottom:unset">
                <h1>referenser</h1>
                <ul>
                    <?php foreach ($references as $reference) { ?>
                        <li><?php echo $reference["company"] . " - " . $reference["name"] . " - " . $reference["tel"] ; ?></li>
                    <?php
                    } ?>
                </ul>
            </div>
            <div class="projects" style="margin-top:100%;padding-top:30%">
                <h1>projekt</h1>
                <ul style="list-style:disc;font-size:16px;padding-left:2%;">
                    <?php foreach ($projects as $project) { ?>
                        <li style="margin-bottom:2%;"><?php echo (!$project["innerText"] ? $project["title"]:$project["title"] . " - " . $project["innerText"]); ?></li>
                    <?php
                    } ?>
                </ul>
            </div>
            <div class="languages">
                <h1>Språk</h1>
                <ul style="list-style:disc;padding-left:15px">
                    <?php foreach ($languages as $language) { ?>
                        <li><?php echo $language["languages"]; ?></li>
                        <?php
                    } ?>
                </ul>
            </div>
        </div>

        <div class="right">
            <div class="jobexperiences">
                <h1>erfarenheter</h1>
                <?php
                foreach ($jobexperiences as $jobexperience) { ?>
                    <div class="jobexperience">
                        <span><?php echo $jobexperience["date"]; ?></span>
                        <div>
                            <p class="titleCompany"><?php echo (!$jobexperience["company"] ? $jobexperience["title"] :  $jobexperience["title"] . ", " . $jobexperience["company"]); ?></p>
                            <p class="location"><?php echo $jobexperience["location"]; ?></p>
                            <p class="innerText"><?php echo $jobexperience["innerText"]; ?></p>
                            <p class="achievements">Prestationer</p>
                            <ul>
                                <?php foreach (json_decode($jobexperience["achievements"]) as $achievement) {
                                    echo "<li>$achievement</li>";
                                } ?>
                            </ul>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="educations" style="margin-bottom: 124%;">
                <h1>utbildning</h1>
                <?php foreach ($educations as $education) { ?>
                    <div class="education">
                        <span><?php echo $education["date"]; ?></span>
                        <div>
                            <p class="titleCompany"><?php echo $education["title"]; ?></p>
                            <p class="innerText"><?php echo $education["innerText"]; ?></p>
                        </div>
                    </div>
                <?php
                } ?>
            </div>
        </div>

    </div>

    <div id="footer">
        <p><?php echo $userInfo[0]["name"] . " | " . $userInfo[0]["address"] . " - " . $userInfo[0]["city"] . ", " . $userInfo[0]["postalCode"] . " | " . $userInfo[0]["phone"] . " | " . $userInfo[0]["mail"]; ?></p>
    </div>

</body>
</html>
