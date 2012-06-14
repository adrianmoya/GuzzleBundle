Introduction 
============
GuzzleBundle is a Symfony2 bundle for integrating the [Guzzle PHP library](http://github.com/guzzle/guzzle) in your project.

It’s not quite finished.


Installation
------------
  1. Install Guzzle and GuzzleBundle as a Git submodule:

	  $ git submodule add git://github.com/guzzle/guzzle.git vendor/guzzle/guzzle
          $ git submodule add git://github.com/guzzle/GuzzleBundle vendor/bundles/Guzzle/GuzzleBundle

     Or configure your ``deps`` to include the bundle:

          [Guzzle]
              git=git://github.com/guzzle/guzzle.git
              target=guzzle/guzzle

          [GuzzleBundle]
              git=git://github.com/guzzle/GuzzleBundle.git
              target=bundles/Guzzle/GuzzleBundle


  2. Add the Guzzle and GuzzleBundle namespace to your autoloader:

          // app/autoload.php
          $loader->registerNamespaces(array(
                'Guzzle\\GuzzleBundle' => __DIR__.'/../vendor/bundles',
                'Guzzle'               => __DIR__.'/../vendor/guzzle/guzzle/src',
                // your other namespaces
          ));

  3. Add this bundle to your application's kernel:

          // app/AppKernel.php
          public function registerBundles()
          {
              // ...
              new Guzzle\GuzzleBundle\GuzzleGuzzleBundle(),
              // ...
          }

  4. Configure the `service_builder` service, and ensure that the framework is using the filesystem for session storage:

          # app/config/config.yml
          guzzle_guzzle:
              service_builder: ~


  5. And add a Guzzle clients configuration file. See the [Guzzle documentation](http://guzzlephp.org/tour/using_services.html#sourcing-data-from-xml).
        
        // app/config/guzzleclients.xml
        <?xml version="1.0" ?>
        <guzzle>
            <clients>
                <!-- Abstract service to store AWS account credentials -->
                <client name="abstract.aws">
                    <param name="access_key" value="12345" />
                    <param name="secret_key" value="abcd" />
                </client>
                <!-- Amazon S3 client that extends the abstract client -->
                <client name="s3" classs="Guzzle.Aws.S3.S3Client" extends="abstract.aws">
                    <param name="devpay_product_token" value="XYZ" />
                    <param name="devpay_user_token" value="123" />
                </client>
                <client name="simple_db" class="Guzzle.Aws.SimpleDb.SimpleDbClient" extends="abstract.aws" />
                <client name="sqs" class="Guzzle.Aws.Sqs.SqsClient" extends="abstract.aws" />
                <!-- Unfuddle client -->
                <client name="unfuddle" class="Guzzle.Unfuddle.UnfuddleClient">
                    <param name="username" value="test-user" />
                    <param name="password" value="my-password" />
                    <param name="subdomain" value="my-subdomain" />
                </client>
            </clients>
        </guzzle>

Usage
-----

In any of your app controller, use the service builder to instantiate a client:

        $serviceBuilder = $this->get('guzzle.service_builder');
        $client = $serviceBuilder->get('unfuddle');
