<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Usuario Bloqueado</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <style>
            .corral {
                margin: 0 auto;
                width: 460px;
            }

            .contentContainer {
                position: relative;
                margin: 130px auto 0;
                padding: 30px 10% 50px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                -khtml-border-radius: 5px;
                border-radius: 5px;
            }

            .textInput input, .textInput textarea {
                height: 44px;
                width: 100%;
                padding: 0 10px;
                border: 1px solid #9da3a6;
                background: #fff;
                text-overflow: ellipsis;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                -khtml-border-radius: 4px;
                border-radius: 4px;
                -webkit-box-shadow: none;
                -moz-box-shadow: none;
                box-shadow: none;
                color: #000;
                font-size: 1em;
                font-family: Helvetica,Arial,sans-serif;
                font-weight: 400;
                direction: ltr;
            }
            .textInput {
                position: relative;
                margin: 0 0 10px;
            }
            .textInput .fieldLabel {
                position: absolute;
                color: #6c7378;
                clip: rect(1px 1px 1px 1px);
                clip: rect(1px,1px,1px,1px);
                padding: 0;
                border: 0;
                height: 1px;
                width: 1px;
                overflow: hidden;
            }

            a.button:hover, a.button:link:hover, a.button:visited:hover, .button:hover {
                background-color: #005ea6;
                outline: 0;
            }
            a.button, a.button:link, a.button:visited, .button {
                width: 100%;
                height: 44px;
                padding: 0;
                border: 0;
                display: block;
                background-color: #0070ba;
                -webkit-box-shadow: none;
                -moz-box-shadow: none;
                box-shadow: none;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                -khtml-border-radius: 4px;
                border-radius: 4px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                cursor: pointer;
                -webkit-appearance: none;
                -moz-appearance: none;
                -ms-appearance: none;
                -o-appearance: none;
                appearance: none;
                -webkit-tap-highlight-color: transparent;
                color: #fff;
                font-size: 1em;
                text-align: center;
                font-weight: 700;
                font-family: HelveticaNeue-Medium,"Helvetica Neue Medium",HelveticaNeue,"Helvetica Neue",Helvetica,Arial,sans-serif;
                text-shadow: none;
                text-decoration: none;
                -webkit-transition: background-color .4s ease-out;
                -moz-transition: background-color .4s ease-out;
                -o-transition: background-color .4s ease-out;
                transition: background-color .4s ease-out;
                -webkit-font-smoothing: antialiased;
            }

            .actionsSpaced {
                margin-top: 30px;
            }

            .fieldWrapper {
                position: relative;
                z-index: 2;
                width: 100%;
            }

            .forgotLink {
                margin: 20px auto;
                padding-bottom: 20px;
                border-bottom: 1px solid #cbd2d6;
                text-align: center;
            }

            a.button.secondary, a.button.secondary:link, a.button.secondary:visited, .button.secondary {
                background-color: #E1E7EB;
                color: #2C2E2F;
            }
            a.button, a.button:link, a.button:visited {
                padding-top: 11px;
            }

            a, a:link, a:visited {
                color: #0070ba;
                font-family: HelveticaNeue,"Helvetica Neue",Helvetica,Arial,sans-serif;
                font-weight: 400;
                text-decoration: none;
                -webkit-transition: color .2s ease-out;
                -moz-transition: color .2s ease-out;
                -o-transition: color .2s ease-out;
                transition: color .2s ease-out;
            }
        </style>
    </head>
    <body>
        <div id="main" class="main " role="main">
            <section id="login" class="login" data-role="page" data-title="Log in to your PayPal account">
                <div class="corral">
                    <div id="content" class="contentContainer">
                        <header>
                            <p class="paypal-logo paypal-logo-long">
                            <center>
                                <img src="/img/letras.png">
                            </center></p>
                        </header>
                        <form method="POST" action="{{ route('login.unlock') }}" autocomplete='off'>                            @csrf
                            <div id="passwordSection" class="clearfix">
                                <div class="textInput" id="login_emaildiv">
                                    <div align="center">
                                        <h5><b>{{ Auth::user()->name }}</b></h5>
                                    </div>
                                    <label class="text-center">Usuario bloqueado, escriba su contraseña para continuar.</label>
                                </div>
                                <div class="textInput lastInputField" id="login_passworddiv">
                                    <div class="fieldWrapper">
                                        <label for="password" class="fieldLabel">Password</label>
                                        <input id="password" name="password" type="password" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" required="required" aria-required="true"   placeholder="Contraseña">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="actions actionsSpaced">
                                <button class="button actionContinue" type="submit" id="btnLogin" name="btnLogin">Desbloquear</button>
                            </div>
                        </form>
                        <hr>
                        <input type="hidden" id="bp_mid" name="bp_mid" value="">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" class="button secondary">{{ __('Cerrar sesión') }}</a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </section>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
