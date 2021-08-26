<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta property="og:image" content="http://portal.sosftlab.mx" />
    <meta property="og:title" content="SOFTLAPI: Documentación" />
    <meta property="og:locale" content="es_MX" />
    <meta property="og:site_name" content="SOFTLAPI: Documentación" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Consulta Arribos y buques del puerto de manzanillo, de forma gratuita">
    <meta name="description" content="Consulta Arribos y buques del puerto de manzanillo, de forma gratuita">
    <title>SOFTLAPI - Documentación Oficial PHP</title>
    <link href="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/images/favicon.ico" rel="icon" type="image/ico" />
    <style>
      .highlight table td { padding: 5px; }
.highlight table pre { margin: 0; }
.highlight, .highlight .w {
  color: #f8f8f2;
  background-color: #272822;
}
.highlight .err {
  color: #272822;
  background-color: #f92672;
}
.highlight .c, .highlight .cd, .highlight .cm, .highlight .c1, .highlight .cs {
  color: #75715e;
}
.highlight .cp {
  color: #f4bf75;
}
.highlight .nt {
  color: #f4bf75;
}
.highlight .o, .highlight .ow {
  color: #f8f8f2;
}
.highlight .p, .highlight .pi {
  color: #f8f8f2;
}
.highlight .gi {
  color: #a6e22e;
}
.highlight .gd {
  color: #f92672;
}
.highlight .gh {
  color: #66d9ef;
  background-color: #272822;
  font-weight: bold;
}
.highlight .k, .highlight .kn, .highlight .kp, .highlight .kr, .highlight .kv {
  color: #ae81ff;
}
.highlight .kc {
  color: #fd971f;
}
.highlight .kt {
  color: #fd971f;
}
.highlight .kd {
  color: #fd971f;
}
.highlight .s, .highlight .sb, .highlight .sc, .highlight .sd, .highlight .s2, .highlight .sh, .highlight .sx, .highlight .s1 {
  color: #a6e22e;
}
.highlight .sr {
  color: #a1efe4;
}
.highlight .si {
  color: #cc6633;
}
.highlight .se {
  color: #cc6633;
}
.highlight .nn {
  color: #f4bf75;
}
.highlight .nc {
  color: #f4bf75;
}
.highlight .no {
  color: #f4bf75;
}
.highlight .na {
  color: #66d9ef;
}
.highlight .m, .highlight .mf, .highlight .mh, .highlight .mi, .highlight .il, .highlight .mo, .highlight .mb, .highlight .mx {
  color: #a6e22e;
}
.highlight .ss {
  color: #a6e22e;
}
    </style>
    <link href="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/stylesheets/screen.css" rel="stylesheet" media="screen" />
    <link href="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/stylesheets/print.css" rel="stylesheet" media="print" />
      <script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/javascripts/all_nosearch.js"></script>
  </head>

  <body class="index" data-languages="[&quot;shell&quot;,&quot;javascript&quot;,&quot;csharp&quot;,&quot;php&quot;]">
    <a href="index.html#" id="nav-button">
      <span>
        NAV
        <img src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/images/navbar.png" alt="Navbar" />
      </span>
    </a>
    <div class="tocify-wrapper">
    <div class="name" style="background-color: #333;height:80px;">
      <a href="https://www.softlab.mx" target="_blank">
        <img src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/<?php echo $this->sysModule; ?>/view/images/logo.png" width="120px" alt="Logo" />
      </a>

      <div class="name">documentación</div>
      </div>
        <div class="lang-selector">
              <!--<a href="index.html#" data-language-name="shell">cURL</a>
              <a href="index.html#" data-language-name="javascript">Node.js</a>
              <a href="index.html#" data-language-name="csharp">.NET</a>-->
              <a href="index.php#" data-language-name="php">PHP</a>
        </div>
      <div id="toc">
      </div>
        <ul class="toc-footer">
            <li><a href='https://www.softlab.mx' target='_blank'>WEB SERVICES</a></li>
        </ul>
    </div>
    <div class="page-wrapper">
      <div class="dark-box"></div>
      <div class="content">
        
          <h1 id="introducci-n">Introducción</h1>

<p>Consulta de Arribos y zarpes de Manzanillo.</p>

<p>Ideal para implementarlo e incluirlo en tu sistema</p>

<h3 id="caracter-sticas-soportadas">Características </h3>

<ul>
<li><strong>Consulta de </strong> Arribos.</li>
<li><strong>Consulta de </strong> Buques.</li>
 
</ul> 

     
<h3 id="ambientes-y-llaves-secretas">Ambientes  </h3>

 
<h4 id="ambiente-live">Ambiente Producción</h4>

<p><code class="prettyprint">Produccion</code> para consultar los Arribos.</p>
  

          <h1 id="api-referencia">API (Referencia)</h1>

<h2 id="arribosybuques">Arribos y Buques</h2>


<h3 id="lista-de-buques">Lista de Buques</h3>

<blockquote>
<h4 class="toc-ignore">Definición</h4>
</blockquote>
<pre class="highlight plaintext"><code>GET https://portal.softlab.mx/sys/serv/serv-arri/arribos/V1/
</code></pre>
<blockquote>
<h4 class="toc-ignore">Ejemplo de Petición</h4>
</blockquote>
<pre class="highlight php"><code><span class="cp">&lt;?php</span>
<span class="nv">$endpoint_softlapi</span> <span class="o">=</span> <span class="s2">"https://portal.softlab.mx/sys/serv/serv-arri/arribos/"</span>
<span class="nv">$version_softlapi</span> <span class="o">=</span> <span class="s2">"V1/"</span>
<span class="nv">$metodo_softlapi</span> <span class="o">=</span> <span class="s2">"?axn=consultarBuques"</span>

<span class="nv">$buques</span> <span class="o">=</span> <span class="nv">$endpoint_softlapi</span>.<span class="nv">$version_softlapi</span>.<span class="nv">$metodo_softlapi</span> 
<span class="nv">$resultados</span> <span class="o">=</span> <span class="na">file_get_contents(</span><span class="nv">$buques</span><span class="nv">)</span> 
<!--<span class="nv">$response</span> <span class="o">=</span> <span class="na">json_decode(</span><span class="nv">$resultados</span><span class="nv">,TRUE,512)</span> -->
</code></pre>
<blockquote>
<h4 class="toc-ignore">Respuesta JSON</h4>
</blockquote>
  <!--</span><span class="nt">"page"</span><span class="p">:</span><span class="w"> </span><span class="mi">1</span><span class="p">,</span><span class="w">
  </span><span class="nt">"total_pages"</span><span class="p">:</span><span class="w"> </span><span class="mi">1</span><span class="p">,</span><span class="w">-->
     <!-- </span><span class="nt">"tipoTrafico"</span><span class="p">:</span><span class="w"> </span><span class="kc">Altura</span><span class="p">,</span><span class="w">-->
<pre class="highlight json"><code><span class="p">{</span><span class="w"></span>
  </span><span class="nt">"totalResultados"</span><span class="p">:</span><span class="w"> </span><span class="mi">1</span><span class="p">,</span><span class="w">
  </span><span class="nt">"datos"</span><span class="p">:</span><span class="w"> </span><span class="p">[</span><span class="w">
    </span><span class="p">{</span><span class="w">
      </span><span class="nt">"codigo"</span><span class="p">:</span><span class="w"> </span><span class="s2">"f831d4cd-fcba-11eb-a469-90b11c129156"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"fechaCreacion"</span><span class="p">:</span><span class="w"> </span><span class="s2">"2021-08-14 00:49:13"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"tipoTrafico"</span><span class="p">:</span><span class="w"> </span><span class="kc">Altura</span><span class="p">,</span><span class="w">
      </span><span class="nt">"lineaNaviera"</span><span class="p">:</span><span class="w"> </span><span class="s2">"Dunder Mifflin S.A. de C.V."</span><span class="p">,</span><span class="w">
      </span><span class="nt">"bandera"</span><span class="p">:</span><span class="w"> </span><span class="s2">"SG"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"buque"</span><span class="p">:</span><span class="w"> </span><span class="s2">"A.P. MOLLER"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"estatus"</span><span class="p">:</span><span class="w"> </span><span class="s2">"Activo"</span><span class="p">,</span><span class="w">
    </span><span class="p">}</span><span class="w">
  </span><span class="p">]</span><span class="w">
</span><span class="p">}</span><span class="w">
</span></code></pre>
<p>Obtiene la lista paginada de buques.</p>

<h4 id="argumentos-url-query">Argumentos (URL query)</h4>

<table><thead>
<tr>
<th style="text-align: right">Argumento</th>
<th style="text-align: center">Tipo</th>
<th style="text-align: center">Default</th>
<th>Descripción</th>
</tr>
</thead><tbody>
  <tr>
    <td style="text-align: right"><strong>codigo</strong><br><small>opcional</small></td>
    <td style="text-align: center">string</td>
    <td style="text-align: center">none</td>
    <!--<td style="text-align: center">&ldquo;&rdquo;</td>-->
    <td>Consulta el buque por el codigo .</td>
  </tr> 
<tr>
<td style="text-align: right"><strong>buque</strong><br><small>opcional</small></td>
<td style="text-align: center">string</td>
<td style="text-align: center">none</td>
 <td>Consulta. Texto a buscar en <code class="prettyprint">buque</code>  .</td>
</tr> 
<tr>
  <td style="text-align: right"><strong>lineaNaviera</strong><br><small>opcional</small></td>
  <td style="text-align: center">string</td>
  <td style="text-align: center">none</td>
   <td>Consulta. Texto a buscar en <code class="prettyprint">lineaNaviera</code>  .</td>
  </tr> 
  <tr>
  <td style="text-align: right"><strong>bandera</strong><br><small>opcional</small></td>
  <td style="text-align: center">string</td>
  <td style="text-align: center">none</td>
    <td>Consulta. Texto a buscar en <code class="prettyprint">bandera</code>  .</td>
  </tr> 
<tr>
<td style="text-align: right"><strong>fechaCreacion</strong><br><small>opcional</small></td>
<td style="text-align: center">string</td>
<td style="text-align: center">none</td>
<td>Regresa el buque cuya fecha de creación es igual a esta fecha.</td>
</tr>
<tr>
<td style="text-align: right"><strong>limite</strong><br><small>opcional</small></td>
<td style="text-align: center">integer</td>
<td style="text-align: center">50</td>
<td>Número del 1 al 50 que representa la cantidad máxima de resultados a regresar con motivos de paginación.</td>
</tr>
<tr>
<td style="text-align: right"><strong>pagina</strong><br><small>opcional</small></td>
<td style="text-align: center">integer</td>
<td style="text-align: center">1</td>
<td>Página de resultados a regresar, empezando desde la página 1.</td>
</tr>
</tbody></table>


<h3 id="lista-de-arribos">Lista de Arribos</h3>

<blockquote>
<h4 class="toc-ignore">Definición</h4>
</blockquote>
<pre class="highlight plaintext"><code>GET https://portal.softlab.mx/sys/serv/serv-arri/arribos/V1/
</code></pre>
<blockquote>
<h4 class="toc-ignore">Ejemplo de Petición</h4>
</blockquote>
<pre class="highlight php"><code><span class="cp">&lt;?php</span>
  <span class="nv">$endpoint_softlapi</span> <span class="o">=</span> <span class="s2">"https://portal.softlab.mx/sys/serv/serv-arri/arribos/"</span>
  <span class="nv">$version_softlapi</span> <span class="o">=</span> <span class="s2">"V1/"</span>
  <span class="nv">$metodo_softlapi</span> <span class="o">=</span> <span class="s2">"?axn=consultarArribos"</span></code></pre>
<blockquote>
<h4 class="toc-ignore">Respuesta JSON</h4>
</blockquote>
<pre class="highlight json"><code><span class="p">{</span><span class="w"> 
  <span class="nt">"totalResultados"</span><span class="p">:</span><span class="w"> </span><span class="mi">1</span><span class="p">,</span><span class="w">
  </span><span class="nt">"datos"</span><span class="p">:</span><span class="w"> </span><span class="p">[</span><span class="w">
    </span><span class="p">{</span><span class="w">
      </span><span class="nt">"codigoArribo"</span><span class="p">:</span><span class="w"> </span><span class="s2">"36543"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"codigoPuerto"</span><span class="p">:</span><span class="w"> </span><span class="s2">"100086938"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"codigoAtraque"</span><span class="p">:</span><span class="w"> </span><span class="kc">Pendiente</span><span class="p">,</span><span class="w">
      </span><span class="nt">"viaje"</span><span class="p">:</span><span class="w"> </span><span class="s2">"001ZLOBLBBALA21S"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"indicativoLlamada"</span><span class="p">:</span><span class="w"> </span><span class="s2">"XCBG4"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"lineaNaviera"</span><span class="p">:</span><span class="w"> </span><span class="s2">"BAJA FERRIS"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"buque"</span><span class="p">:</span><span class="w"> </span><span class="s2">"BALANDRA STAR"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"codigo"</span><span class="p">:</span><span class="w"> </span><span class="s2">"f7ce2b96-fcba-11eb-a469-90b11c129156"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"bandera"</span><span class="p">:</span><span class="w"> </span><span class="s2">"MX"</span><span class="p">,</span><span class="w">
      </span><span class="nt">"estatus"</span><span class="p">:</span><span class="w"> </span><span class="s2">"Activo"</span><span class="p">,</span><span class="w">
      </span> <span class="w">
    </span><span class="p">}</span><span class="w">
  </span><span class="p">]</span><span class="w">
</span><span class="p">}</span><span class="w">
</span></code></pre>
<p>Obtiene la lista paginada de arribos.</p>

<h4 id="argumentos-url-query">Argumentos (URL query)</h4>

<table><thead>
<tr>
<th style="text-align: right">Argumento</th>
<th style="text-align: center">Tipo</th>
<th style="text-align: center">Default</th>
<th>Descripción</th>
</tr>
</thead><tbody>
<tr>
<td style="text-align: right"><strong>buque</strong><br><small>opcional</small></td>
<td style="text-align: center">string</td>
<td style="text-align: center">none</td>
<td>Consulta. Texto a buscar en <code class="prettyprint">buque</code>.</td>
</tr>
<tr>
  <td style="text-align: right"><strong>viaje</strong><br><small>opcional</small></td>
  <td style="text-align: center">string</td>
  <td style="text-align: center">none</td>
  <td>Consulta. Texto a buscar en <code class="prettyprint">viaje</code>.</td>
  </tr>
<td style="text-align: right"><strong>limite</strong><br><small>opcional</small></td>
<td style="text-align: center">integer</td>
<td style="text-align: center">50</td>
<td>Número del 1 al 50 que representa la cantidad máxima de resultados a regresar con motivos de paginación.</td>
</tr>
<tr>
<td style="text-align: right"><strong>pagina</strong><br><small>opcional</small></td>
<td style="text-align: center">integer</td>
<td style="text-align: center">1</td>
<td>Página de resultados a regresar, empezando desde la página 1.</td>
</tr>
</tbody></table>

          <h1 id="errores">Errores</h1>

<h2 id="manejo-de-errores">Manejo de errores</h2>

<h2 id="c-digos-de-error">Códigos de error</h2>

<table><thead>
<tr>
<th>Error Code</th>
<th>Meaning</th>
</tr>
</thead><tbody>
<tr>
<td>400</td>
<td>Bad Request &ndash; Los parámetros que enviaste están incompletos o son inválidos.</td>
</tr>
<tr>
<td>401</td>
<td>Unauthorized &ndash; Olvidaste poner la version.</td>
</tr>
<tr>
<td>403</td>
<td>Forbidden &ndash; Entendimos la petición y sabemos quién eres, pero no se supone que estés haciendo esto.</td>
</tr>
<tr>
<td>404</td>
<td>Not Found &ndash; No pudimos encontrar lo que sea que estás solicitando.</td>
</tr>
<tr>
<td>429</td>
<td>Too Many Requests &ndash; Estás usando nuestro servicio muy frecuentemente. Si ves esto, contáctanos para saber que no intentas atacarnos.</td>
</tr>
<tr>
<td>500</td>
<td>Internal Server Error &ndash; Ocurrió un error en nuestro servidor que no vimos venir. Intenta más tarde.</td>
</tr>
<tr>
<td>503</td>
<td>Service Unavailable &ndash; Estamos actualizando el servicio o dando mantenimiento al servidor.</td>
</tr>
</tbody></table>

      </div>
      <div class="dark-box">
          <div class="lang-selector">
                <!--<a href="index.html#" data-language-name="shell">cURL</a>
                <a href="index.html#" data-language-name="javascript">Node.js</a>
                <a href="index.html#" data-language-name="csharp">.NET</a>-->
                <a href="#" data-language-name="php">PHP</a>
          </div>
      </div>
    </div>
     
   
  </body>
</html>
