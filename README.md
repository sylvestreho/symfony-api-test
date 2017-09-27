Rest API Test
=============

  This project aims to help you to quickly start a Rest API secured by OAUTH2 with Symfony 3.3.


Get started
-----------

  Install the pre requisites and the database:
  `composer install`
  `php bin/console doctrine:schema:update --force`

  Insert an OAuth2 client:
  ```sh
  mysql> INSERT INTO `oauth2_clients` VALUES (NULL, '3bcbxd9e24g0gk4swg0kwgcwg4o8k8g4g888kwc44gcc0gwwk4', 'a:0:{}', '4ok2x70rlfokc8g0wws8c8kwcokw80k44sg48goc0ok4w0so0k', 'a:1:{i:0;s:8:"password";}'); 
  ```

  Create an admin user:
  `php bin/console fos:user:create`
  ```sh
  Please choose a username:admin
  Please choose an email:admin@example.com
  Please choose a password:admin
  Created user admin
  ```


How to test API
---------------

  `curl --header "Content-type: application/json" --request POST --data '{"grant_type": "password", "client_id": "1_3bcbxd9e24g0gk4swg0kwgcwg4o8k8g4g888kwc44gcc0gwwk4", "client_secret": "4ok2x70rlfokc8g0wws8c8kwcokw80k44sg48goc0ok4w0so0k", "username":"admin", "password": "admin"}' http://localhost/oauth/v2/token`

  This should return your access token with the following format:
  
  ```sh
  {"access_token":"N2ExODhjODk4NmUwODNhY2ZhZTVjM2FjYTBlOWM1YzljYjc2YWUxNzMxY2E5MGRhYTkxZGU5ODk2ZGY3OTU1Mw","expires_in":3600,"token_type":"bearer","scope":null,"refresh_token":"MDU0NWIxOTJlMGIyZjI4ZTIzMTllOTZmNzllMzcyMmRiNWZkMWEwNjJkODRhOTA1YThhZDlkMzY5MGFkMDAwOQ"}
  ```

  Now that you are authenticated, you can test that the API responds accordingly:

  `curl --header "Content-type: application/json" -H "Authorization: Bearer N2ExODhjODk4NmUwODNhY2ZhZTVjM2FjYTBlOWM1YzljYjc2YWUxNzMxY2E5MGRhYTkxZGU5ODk2ZGY3OTU1Mw" --request GET http://localhost/api/welcome`

  > Note that the string N2ExODhjODk4NmUwODNhY2ZhZTVjM2FjYTBlOWM1YzljYjc2YWUxNzMxY2E5MGRhYTkxZGU5ODk2ZGY3OTU1Mw will have to be replaced by the output you get after authentication.


  The Rest API should return a JSON response:

  ```sh
  {"hello":"world"}
  ```

  API Documentation is available at the following unprotected URL:
  ```sh
  http://localhost/api/doc
  ```

Contact
-------
  sylvestre.business@gmail.com


Credits
-------
  [diegonobre](https://gist.github.com/diegonobre/341eb7b793fc841c0bba3f2b865b8d66)


License
-------
  Rest API Test is MIT licensed.