<?php
    /* JSON */

    # função file_get_contents para ler o arquivo json
    $cores_json = file_get_contents('./colors.json');
    
    # função json_decode para transformar o json em uma array php
    $cores = json_decode($cores_json);

    # agora podemos fazer um laço for e acessar suas propriedades como uma array PHP comum
    foreach($cores as $cor) {
        echo $cor->name . PHP_EOL;
    }

    echo PHP_EOL;

    /* XML */

    # função simplexml_load_file lê o arquivo xml e retorna uma objeto SimpleXMLElement com vários outros dentro que pode ser iterado
    $estados = simplexml_load_file('./states.xml');

    # podemos iterar o objeto SimpleXMLElement e utilizar a função attributes para acessar os atributos
    foreach($estados as $estado) {
        echo (string) $estado->attributes()->name . PHP_EOL;
    }

    /* API */

    # API que retorna dados de atores de series
    function find_actor($name) {
        # utiliza-se as funções curl para fazer requisições HTTP no PHP
        # função para inicializar
        $ch = curl_init();
        
        # função curl_setopt para definir opções da requisição, como a url
        curl_setopt($ch, CURLOPT_URL, 'https://api.tvmaze.com/search/people?' . http_build_query(['q' => $name]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        # a api retorna um json, portanto deve ser convertido em string pela função json_decode
        # a função curl_exec executa de fato a requisição
        $response = json_decode(curl_exec($ch));

        # é preciso fechar a conexão para não ocorrer memory leak
        curl_close($ch);

        # agora podemos manipular a resposta da api como um objeto PHP
        echo PHP_EOL;
        echo 'Name: ' . $response[0]->person->name . PHP_EOL;
        echo 'Country: ' . $response[0]->person->country->name . PHP_EOL;
        echo 'Photo: ' . $response[0]->person->image->original . PHP_EOL;
    }

    find_actor('Park Ju Hyun');
    find_actor('Go Min Si');
?>
