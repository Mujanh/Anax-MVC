<h1>Kasta tärning!</h1>

<p>Hur många kast vill du göra, <a href='<?=$this->url->create("dice/roll?roll=1")?>'>1 kast</a>, <a href='<?=$this->url->create("dice/roll?roll=3")?>'>3 kast</a> eller <a href='<?=$this->url->create("dice/roll?roll=6")?>'>6 kast</a>? </p>

<?php if(isset($roll)) : ?>
<p>Du valde <?=$roll?> kast och fick följande tärningsserie:</p>

<ul class='dice'>
<?php foreach($results as $val) : ?>
<li class='dice-<?=$val?>'></li>
<?php endforeach; ?>
</ul>

<p>Totalt fick du <?=$total?></p>
<?php endif; ?>
