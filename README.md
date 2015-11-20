# ¿Qué es esto?

Clases básicas para a instanciación de respuestas tipo API.

# Instalación vía composer:

Esta biblioteca puede instalarse vía composer añadiendo esto a tu fichero composer.json:

    {
      "require": {
        "h4d/api-response": "^1.0"
      },
      "repositories": [
        {
          "type": "vcs",
          "url": "git@dev.edusalguero.com:h4d/api-response.git"
        }
      ]
    }
    
# Uso directo

    $resp = new ApiResponse(10000, ['version'=>'1.0'], 'Success!');

# Uso en cliente

    // Array proveniente de descodificar un JSON de respuesta.
    $dataArray = ['code'=>10000, 'data'=> ['version'=>'v1.0'], 'message'=>'Success!'];
    // Obtengo el objeto de respuesta a partir de la factoría.
    $resp = ApiResponseFactory::i()->fromArray($dataArray);
    if ($resp->isOK())
    {
        // Hago cosas...
    }



