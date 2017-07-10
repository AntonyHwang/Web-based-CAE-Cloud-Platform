<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{% block title %}Material Base{% endblock %}</title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url_for('static', filename='mystyle.css') }}?version=2" type="text/css" />
    {% block head %}{% endblock%}
</head>

<body>


    <div class="drawer">

        <ul class="nav nav-tabs">
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Dropdown <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">LogOut</a></li>
                </ul>
            </li>

            <li role="presentation"><a href="#">Upload</a></li>
            <li role="presentation"><a href="#">Jobs</a></li>
        </ul>


    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" id="content">
            {% block content %}{% endblock %}
        </div>
        <div class="col-md-2"></div>
    </div>


</body>