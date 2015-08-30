<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 

// Read config for theme
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');

//Set clean urls
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

// Read config for navbar
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

// Route to start page
$app->router->add('', function() use ($app) {
		$app->theme->setTitle("Välkommen");
		
		$content = $app->fileContent->get('me.md');
		$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
		
		$byline  = $app->fileContent->get('byline.md');
		$byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
		
		$app->views->add('me/page', [
			'content' => $content,
			'byline' => $byline,
		]); 
});

// Route to report page
$app->router->add('redovisning', function() use ($app) {
		$app->theme->setTitle("Redovisning");
		
		$content = $app->fileContent->get('redovisning.md');
		$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
		
		$byline  = $app->fileContent->get('byline.md');
		$byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
		
		$app->views->add('me/page', [
			'content' => $content,
			'byline' => $byline,
		]);
});

//Set routes for dice roll
$app->router->add('dice', function() use ($app) {
	$app->theme->addStylesheet('css/dice.css');
    $app->theme->setTitle("Kasta tärning");
 
    $app->views->add('me/dice');
    $app->theme->setTitle("Roll a dice");
});

// Route to roll dice and show results
$app->router->add('dice/roll', function() use ($app) {
	$app->theme->addStylesheet('css/dice.css');
    
	// Check how many rolls to do
    $roll = $app->request->getGet('roll', 1);
    $app->validate->check($roll, ['int', 'range' => [1, 100]])
        or die("Roll out of bounds");
 
    // Make roll and prepare reply
    $dice = new \Mos\Dice\CDice();
    $dice->roll($roll);
 
    $app->views->add('me/dice', [
        'roll'      => $dice->getNumOfRolls(),
        'results'   => $dice->getResults(),
        'total'     => $dice->getTotal(),
    ]);
 
    $app->theme->setTitle("Rolled a dice");
 
});

// Route to source code
$app->router->add('source', function() use ($app) {
	$app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Källkod");
 
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);
 
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
});




//Render routes using router engine
$app->router->handle();
// Render the response using theme engine.
$app->theme->render();