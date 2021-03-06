--TEST--
toc render of option Hoedown::TOC_ESCAPE
--SKIPIF--
--FILE--
<?php
$text = <<<EOT
# a

hoge

## b

foo

### `code`

huge
EOT;

$hoedown = new Hoedown;

$hoedown->setOption(Hoedown::TOC, true);

$opt = Hoedown::TOC_ESCAPE;

echo "== default renderer and state ==\n";
var_dump($hoedown->getOption($opt));
echo $hoedown->parse($text, $state);
if (array_key_exists('toc', $state)) {
    echo ": toc\n";
    echo $state['toc'];
}

echo "== toc renderer ==\n";
$hoedown->setOption(Hoedown::RENDERER_TOC, true);
var_dump($hoedown->getOption($opt));
echo $hoedown->parse($text);

$hoedown->setOption($opt, false);
$hoedown->setOption(Hoedown::RENDERER_HTML, true);

echo "== escape disable: default renderer and state ==\n";
var_dump($hoedown->getOption($opt));
echo $hoedown->parse($text, $state);
if (array_key_exists('toc', $state)) {
    echo ": toc\n";
    echo $state['toc'];
}

echo "== escape disable: toc renderer ==\n";
$hoedown->setOption(Hoedown::RENDERER_TOC, true);
var_dump($hoedown->getOption($opt));
echo $hoedown->parse($text);

$hoedown->setOption($opt, true);
$hoedown->setOption(Hoedown::RENDERER_HTML, true);

echo "== escape enable: default renderer and state ==\n";
var_dump($hoedown->getOption($opt));
echo $hoedown->parse($text, $state);
if (array_key_exists('toc', $state)) {
    echo ": toc\n";
    echo $state['toc'];
}

--EXPECTF--
== default renderer and state ==
bool(true)
<h1 id="toc_a">a</h1>

<p>hoge</p>

<h2 id="toc_b">b</h2>

<p>foo</p>

<h3 id="toc_-code-code--code-"><code>code</code></h3>

<p>huge</p>
: toc
<ul>
<li>
<a href="#toc_a">a</a>
<ul>
<li>
<a href="#toc_b">b</a>
<ul>
<li>
<a href="#toc_-code-code--code-">&lt;code&gt;code&lt;/code&gt;</a>
</li>
</ul>
</li>
</ul>
</li>
</ul>
== toc renderer ==
bool(true)
<ul>
<li>
<a href="#toc_a">a</a>
<ul>
<li>
<a href="#toc_b">b</a>
<ul>
<li>
<a href="#toc_-code-code--code-">&lt;code&gt;code&lt;/code&gt;</a>
</li>
</ul>
</li>
</ul>
</li>
</ul>
== escape disable: default renderer and state ==
bool(false)
<h1 id="toc_a">a</h1>

<p>hoge</p>

<h2 id="toc_b">b</h2>

<p>foo</p>

<h3 id="toc_-code-code--code-"><code>code</code></h3>

<p>huge</p>
: toc
<ul>
<li>
<a href="#toc_a">a</a>
<ul>
<li>
<a href="#toc_b">b</a>
<ul>
<li>
<a href="#toc_-code-code--code-"><code>code</code></a>
</li>
</ul>
</li>
</ul>
</li>
</ul>
== escape disable: toc renderer ==
bool(false)
<ul>
<li>
<a href="#toc_a">a</a>
<ul>
<li>
<a href="#toc_b">b</a>
<ul>
<li>
<a href="#toc_-code-code--code-"><code>code</code></a>
</li>
</ul>
</li>
</ul>
</li>
</ul>
== escape enable: default renderer and state ==
bool(true)
<h1 id="toc_a">a</h1>

<p>hoge</p>

<h2 id="toc_b">b</h2>

<p>foo</p>

<h3 id="toc_-code-code--code-"><code>code</code></h3>

<p>huge</p>
: toc
<ul>
<li>
<a href="#toc_a">a</a>
<ul>
<li>
<a href="#toc_b">b</a>
<ul>
<li>
<a href="#toc_-code-code--code-">&lt;code&gt;code&lt;/code&gt;</a>
</li>
</ul>
</li>
</ul>
</li>
</ul>
