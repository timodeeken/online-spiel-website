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

/* pages/register.twig */
class __TwigTemplate_a11cb880c591781758ab586de41dab55545ab522d9288b2a190e040fb10a5481 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "index.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("index.twig", "pages/register.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "    Beta Register
";
    }

    // line 6
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        echo "    <div class=\"card card-body\">
        <div class=\"row mb-4\">
          <div class=\"col\">
            <ul class=\"nav nav-pills justify-content-center\">
              <li class=\"nav-item\">
                <a class=\"nav-link active\" aria-current=\"page\" href=\"/\">Register</a>
              </li>
              ";
        // line 14
        if (($context["IsUser"] ?? null)) {
            // line 15
            echo "                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"/accountpanel\">Accountpanel</a>
                </li>
                ";
        } else {
            // line 19
            echo "                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"/login\">Login</a>
                </li>
              ";
        }
        // line 23
        echo "            </ul>
          </div>
        </div>
        <div class=\"card-title\">
            Register
        </div>
       ";
        // line 29
        $this->loadTemplate("extensions/notification.twig", "pages/register.twig", 29)->display($context);
        // line 30
        echo "        <div class=\"row\">
            <div class=\"col\">
                <form method=\"POST\" action=\"/\">
                    <div class=\"mb-3\">
                      <label for=\"username\" class=\"form-label\">Account ID</label>
                      <input type=\"text\" class=\"form-control\" id=\"username\" name=\"username\" minlength=\"6\" maxlength=\"16\" required>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"nickname\" class=\"form-label\">Nickname</label>
                        <input type=\"text\" class=\"form-control\" name=\"nickname\">
                      </div>
                    <div class=\"mb-3\">
                        <div class=\"row\">
                            <div class=\"col\">
                               <label for=\"username\" class=\"form-label\">Password</label>
                              <input type=\"password\" class=\"form-control\" name=\"password\" minlength=\"6\" maxlength=\"16\" required>
                            </div>
                            <div class=\"col\">
                                <label for=\"username\" class=\"form-label\">Password Repeat</label>
                              <input type=\"password\" class=\"form-control\" name=\"password_repeat\" minlength=\"6\" maxlength=\"16\" required>
                            </div>
                          </div>
                    </div>
                    <div class=\"mb-3\">
                        <div class=\"row\">
                            <div class=\"col\">
                               <label for=\"email\" class=\"form-label\">E-Mail</label>
                              <input type=\"email\" class=\"form-control\" name=\"email\" required>
                            </div>
                            <div class=\"col\">
                                <label for=\"username\" class=\"form-label\">E-Mail Repeat</label>
                              <input type=\"email\" class=\"form-control\" name=\"email_repeat\" required>
                            </div>
                          </div>
                    </div>
                    <div class=\"mb-3\">
                        <div class=\"row\">
                            <div class=\"col\">
                               <label for=\"email\" class=\"form-label\">Secret Question</label>
                               <select id=\"inputState\" name=\"question\" class=\"form-select\" required>
                                <option selected>Choose</option>
                                <option>Dein favorisiertes Schulfach ist ...?</option>
                                <option>Dein Geburtsort war ...?</option>
                                <option>Dein Lieblingsverein ist ...?</option>
                                <option>Der Name deines ersten Haustieres war ...?</option>
                                <option>Dein erstes Computerspiel war ...?</option>
                                <option>Deine absolute Lieblingsfarbe ist ...?</option>
                              </select>
                            </div>
                            <div class=\"col\">
                                <label for=\"username\" class=\"form-label\">Secret Answer</label>
                              <input type=\"password\" class=\"form-control\" name=\"answer\" required>
                            </div>
                          </div>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"username\" class=\"form-label\">Birthday</label>
                        <input type=\"date\" class=\"form-control\" name=\"birthday\" required>
                      </div>
                      <input type=\"hidden\" name=\"recaptcha_response\" id=\"recaptchaResponse\">
                    <button type=\"submit\" class=\"btn btn-primary\" >Register Now</button>
                  </form>
            </div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "pages/register.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  93 => 30,  91 => 29,  83 => 23,  77 => 19,  71 => 15,  69 => 14,  60 => 7,  56 => 6,  51 => 3,  47 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"index.twig\" %}
{% block title %}
    Beta Register
{% endblock %}

{% block content %}
    <div class=\"card card-body\">
        <div class=\"row mb-4\">
          <div class=\"col\">
            <ul class=\"nav nav-pills justify-content-center\">
              <li class=\"nav-item\">
                <a class=\"nav-link active\" aria-current=\"page\" href=\"/\">Register</a>
              </li>
              {% if IsUser %}
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"/accountpanel\">Accountpanel</a>
                </li>
                {% else %}
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"/login\">Login</a>
                </li>
              {% endif %}
            </ul>
          </div>
        </div>
        <div class=\"card-title\">
            Register
        </div>
       {% include \"extensions/notification.twig\" %}
        <div class=\"row\">
            <div class=\"col\">
                <form method=\"POST\" action=\"/\">
                    <div class=\"mb-3\">
                      <label for=\"username\" class=\"form-label\">Account ID</label>
                      <input type=\"text\" class=\"form-control\" id=\"username\" name=\"username\" minlength=\"6\" maxlength=\"16\" required>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"nickname\" class=\"form-label\">Nickname</label>
                        <input type=\"text\" class=\"form-control\" name=\"nickname\">
                      </div>
                    <div class=\"mb-3\">
                        <div class=\"row\">
                            <div class=\"col\">
                               <label for=\"username\" class=\"form-label\">Password</label>
                              <input type=\"password\" class=\"form-control\" name=\"password\" minlength=\"6\" maxlength=\"16\" required>
                            </div>
                            <div class=\"col\">
                                <label for=\"username\" class=\"form-label\">Password Repeat</label>
                              <input type=\"password\" class=\"form-control\" name=\"password_repeat\" minlength=\"6\" maxlength=\"16\" required>
                            </div>
                          </div>
                    </div>
                    <div class=\"mb-3\">
                        <div class=\"row\">
                            <div class=\"col\">
                               <label for=\"email\" class=\"form-label\">E-Mail</label>
                              <input type=\"email\" class=\"form-control\" name=\"email\" required>
                            </div>
                            <div class=\"col\">
                                <label for=\"username\" class=\"form-label\">E-Mail Repeat</label>
                              <input type=\"email\" class=\"form-control\" name=\"email_repeat\" required>
                            </div>
                          </div>
                    </div>
                    <div class=\"mb-3\">
                        <div class=\"row\">
                            <div class=\"col\">
                               <label for=\"email\" class=\"form-label\">Secret Question</label>
                               <select id=\"inputState\" name=\"question\" class=\"form-select\" required>
                                <option selected>Choose</option>
                                <option>Dein favorisiertes Schulfach ist ...?</option>
                                <option>Dein Geburtsort war ...?</option>
                                <option>Dein Lieblingsverein ist ...?</option>
                                <option>Der Name deines ersten Haustieres war ...?</option>
                                <option>Dein erstes Computerspiel war ...?</option>
                                <option>Deine absolute Lieblingsfarbe ist ...?</option>
                              </select>
                            </div>
                            <div class=\"col\">
                                <label for=\"username\" class=\"form-label\">Secret Answer</label>
                              <input type=\"password\" class=\"form-control\" name=\"answer\" required>
                            </div>
                          </div>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"username\" class=\"form-label\">Birthday</label>
                        <input type=\"date\" class=\"form-control\" name=\"birthday\" required>
                      </div>
                      <input type=\"hidden\" name=\"recaptcha_response\" id=\"recaptchaResponse\">
                    <button type=\"submit\" class=\"btn btn-primary\" >Register Now</button>
                  </form>
            </div>
        </div>
    </div>
{% endblock %}", "pages/register.twig", "C:\\inetpub\\wwwroot\\App\\Views\\pages\\register.twig");
    }
}
