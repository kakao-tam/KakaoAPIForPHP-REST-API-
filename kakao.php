<?php
session_start();
$APP_ADMIN_KEY = "";
$REST_API_KEY = "";
$JAVASCRIPT_KEY = "";
$CHANNEL_ID = "";

if (isset($_GET["sess"]) && $_GET["sess"] == "clear") {
    unset($_SESSION["accessToken"]);
    unset($_SESSION["accessAgree"]);
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="theme-color" content="#000000">
    <base href="/" />
    <link rel="manifest" href="/manifest.json">
    <link rel="shortcut icon" href="/favicon.ico">
    <title>Googsu WebApplication1</title>
    <link href="/static/css/2.86aa6515.chunk.css" rel="stylesheet">
    <link href="/static/css/main.a583af82.chunk.css" rel="stylesheet">
    <!--highlight.js cdn-->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.4.1/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.4.1/highlight.min.js"></script>
    <script>
        hljs.initHighlightingOnLoad();
    </script>
    <!--bootstrapcdn-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>카카오 로그인</title>
    <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
    <script>
        // SDK를 초기화 합니다. 사용할 앱의 JavaScript 키를 설정해 주세요.
        Kakao.init('<?= $JAVASCRIPT_KEY ?>'); //★ 수정 할 것
        // SDK 초기화 여부를 판단합니다.
        console.log(Kakao.isInitialized());
    </script>
</head>

<body>
    <header>
        <nav class="navbar-expand-sm navbar-toggleable-sm ng-white border-bottom box-shadow mb-3 navbar navbar-light">
            <div class="container"><a class="navbar-brand" href="/"><img src="/img/icon/googsu.png" class="logo" alt="logo">Kakao API Test</a>
                <h1>카카오 로그인</h1>
            </div>
        </nav>
    </header>
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item">
                <h2>JavaScript SDK 로그인(Redirect)</h2>
                <a id="custom-login-btn" href="javascript:loginWithKakao()"><img src="//k.kakaocdn.net/14/dn/btqCn0WEmI3/nijroPfbpCa4at5EIsjyf0/o.jpg" width="222" /></a>
                <script type="text/javascript">
                    function loginWithKakao() {
                        Kakao.Auth.authorize({
                            redirectUri: 'http://<?= $_SERVER['HTTP_HOST'] ?>/callBackForKakao.php' //★ 수정 할 것
                        })
                    }
                </script>
                <pre><code class="JavaScript">
// SDK를 초기화 합니다. 사용할 앱의 JavaScript 키를 설정해 주세요.
Kakao.init('{JAVASCRIPT_KEY}'); //★ 수정 할 것
// SDK 초기화 여부를 판단합니다.
console.log(Kakao.isInitialized());

function loginWithKakao() {
    Kakao.Auth.authorize({
        redirectUri: 'http://localhost/callBackForKakao.php' //★ 수정 할 것
    })
}                
                </code></pre>
            </li>
            <li class="list-group-item">
                <h2>JavaScript SDK 로그인(PopUp)</h2>
                <a id="custom-login-btn" href="javascript:loginWithKakaoPopUp()"><img src="//k.kakaocdn.net/14/dn/btqCn0WEmI3/nijroPfbpCa4at5EIsjyf0/o.jpg" width="222" /></a>
                <script type="text/javascript">
                    function loginWithKakaoPopUp() {
                        Kakao.Auth.login({
                            success: function(authObj) {
                                alert(JSON.stringify(authObj));
                                Kakao.Auth.setAccessToken(authObj.access_token);
                                //★ 추가 할 것 : 로그인 성공 후 처리 
                            },
                            fail: function(err) {
                                alert(JSON.stringify(err))
                            },
                        })
                    }
                </script>
                <pre><code class="JavaScript">
function loginWithKakaoPopUp() {
    Kakao.Auth.login({
        success: function(authObj) {
            alert(JSON.stringify(authObj));
            Kakao.Auth.setAccessToken(authObj.access_token);
            //★ 추가 할 것 : 로그인 성공 후 처리 
        },
        fail: function(err) {
            alert(JSON.stringify(err))
        },
    })
}
                </code></pre>
            </li>
            <li class="list-group-item">
                <h2>JavaScript SDK 로그아웃</h2>
                <p>JavaScript SDK로 로그인(PopUp)한 경우만 사용, Redirect로그인 or REST API 로그인은 이후 로직 REST API로 로그아웃 구현 해야함.</p>
                <p>JavaScript SDK를 사용하고자 한다면, Kakao.Auth.setAccessToken(authObj.access_token); 설정 후 사용</p>
                <button type="button" class="btn btn-primary" onclick="javascript:logoutWithKakao()">Kakao LogOut</button>
                <script type="text/javascript">
                    function logoutWithKakao() {
                        if (!Kakao.Auth.getAccessToken()) {
                            console.log('Not logged in.');
                            alert("Not logged in.");
                            return;
                        }
                        console.log(Kakao.Auth.getAccessToken()); //before Logout
                        Kakao.Auth.logout(function() {
                            console.log(Kakao.Auth.getAccessToken()); //after Logout
                            alert("LogOut Success");
                            //★ 추가 할 것 : 로그아웃 성공 후 처리 
                        });
                    }
                </script>
                <pre><code class="JavaScript">
function logoutWithKakao() {
    if (!Kakao.Auth.getAccessToken()) {
        console.log('Not logged in.');
        alert("Not logged in.");
        return;
    }
    console.log(Kakao.Auth.getAccessToken()); //before Logout
    Kakao.Auth.logout(function() {
        console.log(Kakao.Auth.getAccessToken()); //after Logout
        alert("LogOut Success");
        //★ 추가 할 것 : 로그아웃 성공 후 처리 
    });
}
                </code></pre>
            </li>
            <li class="list-group-item">
                <h2>JavaScript 연결 끊기</h2>
                <p>JavaScript SDK로 로그인(PopUp)한 경우만 사용, Redirect로그인 or REST API 로그인은 이후 로직 REST API로 로그아웃 구현 해야함.</p>
                <p>JavaScript SDK를 사용하고자 한다면, Kakao.Auth.setAccessToken(authObj.access_token); 설정 후 사용</p>
                <button type="button" class="btn btn-primary" onclick="javascript:unlinkWithKakao()">Kakao UnLink</button>
                <script type="text/javascript">
                    function unlinkWithKakao() {
                        Kakao.API.request({
                            url: '/v1/user/unlink',
                            success: function(response) {
                                console.log(response);
                            },
                            fail: function(error) {
                                console.log(error);
                            }
                        });
                    }
                </script>
                <pre><code class="JavaScript">
function unlinkWithKakao() {
    Kakao.API.request({
        url: '/v1/user/unlink',
        success: function(response) {
            console.log(response);
        },
        fail: function(error) {
            console.log(error);
        }
    });
}
                </code></pre>
            </li>

            <li class="list-group-item">
                <h2>JavaScript 사용자 정보 가져오기</h2>
                <p>JavaScript SDK로 로그인(PopUp)한 경우만 사용, Redirect로그인 or REST API 로그인은 이후 로직 REST API로 로그아웃 구현 해야함.</p>
                <p>JavaScript SDK를 사용하고자 한다면, Kakao.Auth.setAccessToken(authObj.access_token); 설정 후 사용</p>
                <button type="button" class="btn btn-primary" onclick="javascript:profileWithKakao()">Kakao Profile</button>
                <p id="userid"></p>
                <p id="nickname"></p>
                <img id="profile_image" />
                <img id="thumbnail_image" />
                <script type="text/javascript">
                    function profileWithKakao() {
                        Kakao.API.request({
                            url: '/v2/user/me',
                            success: function(response) {
                                console.log(response);
                                document.getElementById("userid").innerText = response.id;
                                document.getElementById("nickname").innerText = response.kakao_account.profile.nickname;
                                document.getElementById("profile_image").src = response.properties.profile_image;
                                document.getElementById("thumbnail_image").src = response.properties.thumbnail_image;
                            },
                            fail: function(error) {
                                console.log(error);
                            }
                        });
                    }
                </script>
                <pre><code class="JavaScript">
function profileWithKakao() {
    Kakao.API.request({
        url: '/v2/user/me',
        success: function(response) {
            console.log(response);
            document.getElementById("userid").innerText = response.id;
            document.getElementById("nickname").innerText = response.kakao_account.profile.nickname;
            document.getElementById("profile_image").src = response.properties.profile_image;
            document.getElementById("thumbnail_image").src = response.properties.thumbnail_image;
        },
        fail: function(error) {
            console.log(error);
        }
    });
}
                </code></pre>
            </li>

            <li class="list-group-item">
                <h2>REST API 로그인</h2>
                <?php
                //state는 Cross-Site Request Forgery(CSRF) 공격으로부터 보호하기 위해 난수 설정 후, 콜백 페이지에서 검증할 수 있는 기능이나
                //로그인 후, 원래 페이지로 돌아가기 위한 파라메터로 사용하기도 함.
                $state = urlencode("http://" . $_SERVER['HTTP_HOST'] . "/returnPage.php?test=한글&p=인코딩");
                $client_id = $REST_API_KEY; //★ 수정 할 것
                $redirect_uri = urlencode("http://" . $_SERVER['HTTP_HOST'] . "/callBackForKakao.php"); //★ 수정 할 것
                $kakaoLoginUrl = "https://kauth.kakao.com/oauth/authorize?client_id=" . $client_id . "&redirect_uri=" . $redirect_uri . "&response_type=code&state=" . $state;
                ?>
                <a href="<?= $kakaoLoginUrl ?>"><img src="//k.kakaocdn.net/14/dn/btqCn0WEmI3/nijroPfbpCa4at5EIsjyf0/o.jpg" width="222" /></a>
                <pre><code class="PHP">
//state는 Cross-Site Request Forgery(CSRF) 공격으로부터 보호하기 위해 난수 설정 후, 콜백 페이지에서 검증할 수 있는 기능이나
//로그인 후, 원래 페이지로 돌아가기 위한 파라메터로 사용하기도 함.
$state = urlencode("http://" . $_SERVER['HTTP_HOST'] . "/returnPage.php?test=한글&p=인코딩"); 
$client_id = $REST_API_KEY; //★ 수정 할 것
$redirect_uri = urlencode("http://" . $_SERVER['HTTP_HOST'] . "/callBackForKakao.php"); //★ 수정 할 것
$kakaoLoginUrl = "https://kauth.kakao.com/oauth/authorize?client_id=" . $client_id . "&redirect_uri=" . $redirect_uri . "&response_type=code&state=" . $state;
                </code></pre>
            </li>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
