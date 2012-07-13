<?php

/* LobamaSocial2PrintBundle:Default:loading.html.twig */
class __TwigTemplate_080328c08d2343040517ca8663839f79 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "LobamaSocial2PrintBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 8
    public function block_body($context, array $blocks = array())
    {
        // line 9
        echo "<div class=\"content loading\"> 
    <div class=\"inner\">
        <div class=\"progress\">
            <p class=\"progress-teaser\">";
        // line 12
        echo $this->env->getExtension('translator')->getTranslator()->trans("Please wait a moment. We are generating", array(), "messages");
        echo " <br />";
        echo $this->env->getExtension('translator')->getTranslator()->trans("your personal Facebook Poster.", array(), "messages");
        echo "</p>
            <div class=\"progress-bar\"></div> 
            <div class=\"progress-value\">0%</div> 
        </div>
        <div class=\"clearfix\"></div>
    </div>  
</div>
";
    }

    // line 21
    public function block_javascripts($context, array $blocks = array())
    {
        // line 22
        echo "<script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/lobamasocial2print/scripts/debug/libs/yepnope.min.js"), "html", null, true);
        echo "\"></script>

<script> 
        yepnope([{
          load: '//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'
        }, {
          load: '";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/lobamasocial2print/scripts/debug/s2p.js"), "html", null, true);
        echo "',
          complete: function () { 
              s2p.init('POSTER_PREVIEW_LOADER', {
                  container           : '#container',
                  baseURI             : '";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_service"), "html", null, true);
        echo "',
                  dir                 : 'debug/',
                  previewPageURL      : '";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_preview"), "html", null, true);
        echo "',
                  getProgressURL      : '";
        // line 35
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_loading_progress"), "html", null, true);
        echo "',
                  getCollectURL       : '";
        // line 36
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("_create_poster"), "html", null, true);
        echo "',
                  fadeTime            : 440,
                  version             : '0.9.6'
              });
              
         }
        }]);
</script>

";
    }

    public function getTemplateName()
    {
        return "LobamaSocial2PrintBundle:Default:loading.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
