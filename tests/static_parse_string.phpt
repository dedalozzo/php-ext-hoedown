--TEST--
static parse of string
--SKIPIF--
--FILE--
<?php
$text = <<<EOT
# table

First Header  | Second Header
------------- | -------------
Content Cell  | Content Cell
Content Cell  | Content Cel

## fenced code

```php
echo "hello world";
```

### autolink

http://www.php.net/

#### strikethrough

this is ~~good~~ bad.

##### no intra emphasis

hoge_fuga_foo

EOT;

echo "== ofString ==\n";
echo Hoedown::ofString($text);

echo "== ofString : without Hoedown::AUTOLINK ==\n";
echo Hoedown::ofString($text, array(Hoedown::AUTOLINK => false));

echo "== ofString : with Hoedown::TOC ==\n";
echo Hoedown::ofString($text, array(Hoedown::TOC => true), $state);
if (is_array($state) && array_key_exists('toc', $state)) {
    echo ": toc\n";
    echo $state['toc'];
}
unset($state);

echo "== ofString : with Hoedown::TOC and Hoedown::RENDERER_TOC ==\n";
echo Hoedown::ofString($text, array(Hoedown::TOC => true, Hoedown::RENDERER_TOC => true), $state);
if (is_array($state) && array_key_exists('toc', $state)) {
    echo ": toc\n";
    echo $state['toc'];
}

echo "== ofString : empty ==\n";
echo Hoedown::ofString('');

--EXPECTF--
== ofString ==
<h1>table</h1>

<table><thead>
<tr>
<th>First Header</th>
<th>Second Header</th>
</tr>
</thead><tbody>
<tr>
<td>Content Cell</td>
<td>Content Cell</td>
</tr>
<tr>
<td>Content Cell</td>
<td>Content Cel</td>
</tr>
</tbody></table>

<h2>fenced code</h2>

<pre><code class="language-php">echo &quot;hello world&quot;;
</code></pre>

<h3>autolink</h3>

<p><a href="http://www.php.net/">http://www.php.net/</a></p>

<h4>strikethrough</h4>

<p>this is <del>good</del> bad.</p>

<h5>no intra emphasis</h5>

<p>hoge_fuga_foo</p>
== ofString : without Hoedown::AUTOLINK ==
<h1>table</h1>

<table><thead>
<tr>
<th>First Header</th>
<th>Second Header</th>
</tr>
</thead><tbody>
<tr>
<td>Content Cell</td>
<td>Content Cell</td>
</tr>
<tr>
<td>Content Cell</td>
<td>Content Cel</td>
</tr>
</tbody></table>

<h2>fenced code</h2>

<pre><code class="language-php">echo &quot;hello world&quot;;
</code></pre>

<h3>autolink</h3>

<p>http://www.php.net/</p>

<h4>strikethrough</h4>

<p>this is <del>good</del> bad.</p>

<h5>no intra emphasis</h5>

<p>hoge_fuga_foo</p>
== ofString : with Hoedown::TOC ==
<h1 id="toc_table">table</h1>

<table><thead>
<tr>
<th>First Header</th>
<th>Second Header</th>
</tr>
</thead><tbody>
<tr>
<td>Content Cell</td>
<td>Content Cell</td>
</tr>
<tr>
<td>Content Cell</td>
<td>Content Cel</td>
</tr>
</tbody></table>

<h2 id="toc_fenced-code">fenced code</h2>

<pre><code class="language-php">echo &quot;hello world&quot;;
</code></pre>

<h3 id="toc_autolink">autolink</h3>

<p><a href="http://www.php.net/">http://www.php.net/</a></p>

<h4 id="toc_strikethrough">strikethrough</h4>

<p>this is <del>good</del> bad.</p>

<h5 id="toc_no-intra-emphasis">no intra emphasis</h5>

<p>hoge_fuga_foo</p>
: toc
<ul>
<li>
<a href="#toc_table">table</a>
<ul>
<li>
<a href="#toc_fenced-code">fenced code</a>
<ul>
<li>
<a href="#toc_autolink">autolink</a>
<ul>
<li>
<a href="#toc_strikethrough">strikethrough</a>
<ul>
<li>
<a href="#toc_no-intra-emphasis">no intra emphasis</a>
</li>
</ul>
</li>
</ul>
</li>
</ul>
</li>
</ul>
</li>
</ul>
== ofString : with Hoedown::TOC and Hoedown::RENDERER_TOC ==
<ul>
<li>
<a href="#toc_table">table</a>
<ul>
<li>
<a href="#toc_fenced-code">fenced code</a>
<ul>
<li>
<a href="#toc_autolink">autolink</a>
<ul>
<li>
<a href="#toc_strikethrough">strikethrough</a>
<ul>
<li>
<a href="#toc_no-intra-emphasis">no intra emphasis</a>
</li>
</ul>
</li>
</ul>
</li>
</ul>
</li>
</ul>
</li>
</ul>
== ofString : empty ==
