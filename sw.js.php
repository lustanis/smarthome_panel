<?php
session_start();
header('Content-Type: application/javascript');
?>
self.addEventListener('push', function (event) {
    console.log('Received a push message', event);
    <?php
    require_once "domain/User.php";
    $user = new User();?>


    fetch("action/getFreeSpace.php", {
        method: 'post',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'user_id=<?php echo $user->getId();?>'
    })
        .then(function (data) {
            data.json()
                .then(function (data_json) {
                    console.log("space left: " + data_json.space_amount);
                    if (data_json.space_amount < 1.0) {
                        var title = 'Szambo zapełnia się';
                        var body = 'Free space: ' + data_json.space_amount;
                        var icon = 'https://serwer1868388.home.pl/cesspool/resources/flood.512.png';
                        // var tag = 'cesspool-tag';

                        event.waitUntil(
                            self.registration.showNotification(title, {
                                image: icon,
                                body: body
                                //   tag: tag
                            })
                        );
                    }
                })
                .catch(function (error) {
                    console.log('Request failed', error);
                });
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });


    //alert(JSON.stringify(event));

});