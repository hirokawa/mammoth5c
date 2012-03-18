<html>
<head><title>PHPニュース表示</title></head>
<body>
<ul>{foreach $news as $article}
<li><a href="{$article[2]}">{$article[0]}</a>
:{$article[1]}({$article[3]})</li>
{/foreach}</ul>
</body></html>
