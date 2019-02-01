<?php function buildPage($pageName)
{
    require_once 'domain/User.php';
    global $db;
    $user = new User($db);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <link rel="manifest" href="manifest.json">
        <title>CessPool</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css"/>
        <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

        <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

        <script src="https://d3js.org/d3.v5.min.js" charset="utf-8"></script>
        <link href="css/c3.min.css" rel="stylesheet" type="text/css">
        <script src="external/c3.min.js"></script>
    </head>
    <body>
    <?php if ($user->isLogged()) {
        require_once "view/utils/sw_registration.php";
    }?>

    <div data-role="page" data-dom-cache="false" id="mainpage">
        <div data-role="header">
            <div data-role="navbar" data-iconpos="left">
                <ul>
                    <li><a href="#menupanel" class="ui-btn ui-btn-inline ui-corner-all ui-shadow"
                           data-icon="bars">menu</a></li>
                    <li><a href="index.php" data-ajax="false"
                           class="ui-btn ui-btn-inline ui-corner-all ui-shadow">LOGO</a></li>
                    <li><a href="index.php" data-ajax="false" class="ui-btn ui-btn-inline ui-corner-all ui-shadow"
                           data-icon="home">&nbsp;</a></li>
                </ul>
            </div>
        </div>
        <div data-role="panel" id="menupanel" data-display="overlay">
            <ul data-role="listview">
                <?php if ($user->isLogged()) { ?>
                    <li><a href='home.php' data-ajax='false'>Devices</a></li>
                    <li><a href='cesspool.php' data-ajax='false'>Cesspool</a></li>
                    <li><a href='action/logout.php' data-ajax='false'>Wyloguj</a></li>
                <?php } else { ?>
                    <li><a href="login.php" data-ajax="false">Login</a></li>
                    <li><a href="register.php" data-ajax="false">Rejestracja</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="ui-content">
            <?php require_once "view/" . $pageName; ?>
        </div>
    </div>
    <?php handleMessage(); ?>
    </body>
    </html>
<?php }

function handleMessage()
{
    if (isset($_SESSION['message_error']) || isset($_SESSION["message_ok"])) {

        $message = isset($_SESSION['message_error']) ? $_SESSION['message_error'] : $_SESSION["message_ok"];
        unset($_SESSION['message_error']);
        unset($_SESSION["message_ok"]);
        showPopup($message);
    }
}

function showPopup($message)
{ ?>
    <div data-role="popup"
         id="messagePopup1"
         data-history="false"
         data-transition="pop"
         style='background-color: #d6d6d6;'>
         <a href="#"
            data-rel="back"
            class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">
        </a>
        <p><?php echo $message ?></p>
    </div>
    <script type="text/javascript">
        $(document).on({
            "pageshow": function () {
                $("#messagePopup1").popup();
                $("#messagePopup1").popup("open");
            }
        }, "#mainpage");
    </script>
    <?php
}