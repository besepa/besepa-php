# Cliente php para acceso a la API de Besepa

Esta librería es un wrapper de acceso a la API del sistema de pagos por adeudos en cuentas bancarias de Besepa.

## Instalación

    composer require besepa/besepa
    
## Configuración del cliente

Para trabajar con la librería, primero se debe crear una instancia del cliente e inicializarlo con las claves del API de tu panel en Besepa.

    $client = new \Besepa\Client();
    $client->init("besepa_api_key", "besepa_account_id");
    
## Trabajar con repositorios

Cada recurso en la API se gestiona como una entidad y cada entidad, tiene asociado un repositorio.
Por ejemplo, en el caso del recurso Customer, trabajaríamos de esta forma:


    $customerRepository = $client->getRepository("Customer");

    //Crear un customer
    
    $customer = new \Besepa\Entity\Customer();
    $customer->taxid = 'XXXXXXXXXXXA';
    $customer->name  = 'Señor Lobo'
    
    $customerRepository->create($customer);
    
    //Recuperar todos los customers
    $list       = $customerRepository->findAll();
    
    //Recuperar un customer
    $customer_2 = $customerRepository->find('id_de_besepa');
    
### Recursos que dependen de un customer

En ocasiones, necesitamos un customer para gestionar un recurso, para indicarlo, haríamos lo siguiente:

    $bankAccountRepository = $client->getRepository("BankAccount", $customer->id);
    
    $bank_accounts = $bankAccountRepository->findAll();
    
