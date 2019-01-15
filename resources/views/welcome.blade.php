<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Twitter Calculator</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
            <div class="hero">
                <div class="title">
                    <h1>Twitter Reach Calculator</h1>
                </div>

                <form method="POST" action="{{ url('/reach') }}">
                    {{ csrf_field() }}
                    @if($errors->first())
                        <article class="message is-danger">
                            <div class="message-header">
                                <p>Please try again</p>
                                <button class="delete" aria-label="delete"></button>
                            </div>
                            <div class="message-body">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </article>
                    @endif
                    <div class="field">
                      <label class="label">Please enter the Tweets URL to calculate it's reach</label>
                      <div class="control">
                          <input class="input" type="text" name="url"
                                 value="https://twitter.com/elonmusk/status/1083121972857487360" />
                      </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-link">Submit</button>
                        </div>
                    </div>
                </form>

                <div class="hero-content">
                    @isset($reach)
                        <h2>Your tweet has reached <strong>{{ $reach['count'] }}</strong> followers!</h2>
                        <div>
                            <h2 class="title">{{ count($reach['retweeters']) }} Retweeters:</h2>
                            <ul>
                                @foreach($reach['retweeters'] as $retweeter)
                                    <li>{{ $retweeter->name . ' (@' . $retweeter->screen_name . ')' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </body>
</html>
