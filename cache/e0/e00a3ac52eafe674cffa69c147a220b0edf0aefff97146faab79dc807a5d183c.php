<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* index.twig */
class __TwigTemplate_331682e6cfc0adbe7e74cf85724943b3a6879c891d69231ed86e82c92490a85c extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    <link rel=\"stylesheet\" href=\"/assets/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"/assets/css/custom.css\">
    <title>";
        // line 7
        $this->displayBlock('title', $context, $blocks);
        // line 9
        echo " | Tropical Island</title>
</head>
<body>
<div class=\"container\">
    <div class=\"row justify-content-center align-content-center align-items-center\">
        <div class=\"col-sm-6 register\">
            ";
        // line 15
        $this->displayBlock('content', $context, $blocks);
        // line 18
        echo "        </div>
    </div>
    <footer>
        <div class=\"footer-inner mt-5\">
            <p class=\"text-center mt-5\" style=\"font-size: 10px\">
                Webdesign and Coding by <a href=\"https://www.elitepvpers.com/forum/members/6323757--venom-.html\" target=\"_blank\">Venom™</a> | <a href=\"/imprint\">Imprint</a> | <a href=\"https://www.elitepvpers.com/forum/flyff-private-server/\" target=\"_blank\">Elitepvpers</a> | Copyright © 2021 - Tropical Island all rights reserved.
            </p>
        </div>
    </footer>
</div>
<script src=\"https://www.google.com/recaptcha/api.js?render=";
        // line 28
        echo twig_escape_filter($this->env, ($context["SiteKey"] ?? null), "html", null, true);
        echo "\"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('";
        // line 31
        echo twig_escape_filter($this->env, ($context["SiteKey"] ?? null), "html", null, true);
        echo "', {
                action: '/login'
            }).then(function(token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
  </script>
</body>
</html>";
    }

    // line 7
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 8
        echo "        
    ";
    }

    // line 15
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 16
        echo "                
            ";
    }

    public function getTemplateName()
    {
        return "index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 16,  100 => 15,  95 => 8,  91 => 7,  77 => 31,  71 => 28,  59 => 18,  57 => 15,  49 => 9,  47 => 7,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    <link rel=\"stylesheet\" href=\"/assets/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"/assets/css/custom.css\">
    <title>{% block title %}
        
    {% endblock %} | Tropical Island</title>
</head>
<body>
<div class=\"container\">
    <div class=\"row justify-content-center align-content-center align-items-center\">
        <div class=\"col-sm-6 register\">
            {% block content %}
                
            {% endblock %}
        </div>
    </div>
    <footer>
        <div class=\"footer-inner mt-5\">
            <p class=\"text-center mt-5\" style=\"font-size: 10px\">
                Webdesign and Coding by <a href=\"https://www.elitepvpers.com/forum/members/6323757--venom-.html\" target=\"_blank\">Venom™</a> | <a href=\"/imprint\">Imprint</a> | <a href=\"https://www.elitepvpers.com/forum/flyff-private-server/\" target=\"_blank\">Elitepvpers</a> | Copyright © 2021 - Tropical Island all rights reserved.
            </p>
        </div>
    </footer>
</div>
<script src=\"https://www.google.com/recaptcha/api.js?render={{SiteKey}}\"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ SiteKey }}', {
                action: '/login'
            }).then(function(token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
  </script>
</body>
</html>", "index.twig", "C:\\inetpub\\wwwroot\\App\\Views\\index.twig");
    }
}
