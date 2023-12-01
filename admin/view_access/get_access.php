<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>I am not robot</title>

        <link href="/lib/view_access/bootstrap.min.css" rel="stylesheet">

        <link href="/lib/view_access/signin.css" rel="stylesheet">
    </head>

    <body>

        <div class="container">

            <form class="form-signin" method="post">
                <h2 class="form-signin-heading">I am not robot</h2>
                <label for="inputEmail" class="sr-only">Email address</label>
                <img src="/lib/view_access/kapcha.png" />
                <label for="inputPassword" class="sr-only">Code</label>
                <input type="text" name="code" class="form-control" placeholder="Code" required>

                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Sign in
                </button>
            </form>

        </div>
        <!-- /container -->
    </body>
</html>
