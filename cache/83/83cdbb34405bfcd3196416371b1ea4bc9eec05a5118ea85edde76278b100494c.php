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

/* extensions/notification.twig */
class __TwigTemplate_77dd1cb36f0d75c7d1639af871b1a6e6ff06d71685fd18df553b26178b9114ba extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["notifications"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["currentNotification"]) {
            // line 2
            echo "<div class=\"notification\" data-notification-type=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["currentNotification"], "type", [], "any", false, false, false, 2), "html", null, true);
            echo "\">
    ";
            // line 3
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["currentNotification"], "message", [], "any", false, false, false, 3), "html", null, true);
            echo "
</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['currentNotification'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "extensions/notification.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 3,  41 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% for currentNotification in notifications %}
<div class=\"notification\" data-notification-type=\"{{currentNotification.type}}\">
    {{currentNotification.message}}
</div>
{% endfor %}", "extensions/notification.twig", "C:\\inetpub\\wwwroot\\App\\Views\\extensions\\notification.twig");
    }
}
