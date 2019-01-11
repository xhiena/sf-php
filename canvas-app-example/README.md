# SF-PHP canvas app

You will need to create a canvas app in salesforce:

1. Login in salesforce
2. go to setup > Build > Create > Apps
3. in the section `Connected Apps` click New
4. fill in:
    * `Connected App Name`: Name of the app (testcanvas)
    * `API Name`: (testcanvas)
    * `Contact Email` (put your email there)
5. Enable Oauth Settings
    * `Callback URL` where the index.php is (you can use localhost)
    * `Oauth Scopes`: 
        * `Access your basic information`
        * `Full access` (this allows to access all the objects)
    * `Require secret for Web Server Flow` should be enabled
6. Scroll down to the bottom and in the `Canvas app Settings` section:
    * Enable `Canvas`
    * `Canvas app url`: Url of the app
    * `Access Method`: Signed Request (Post)
    * `Locations`: Where are you going to use the app (visualforce Page)

7. Press `save`
8. click to reveal the `Consumer Secret` and paste it on the line 11 of index.php
```
$consumer_secret = 'XXXXXXXXXXXXXXXXXXXXXXXX';
```
9. Go to Setup > Build > Develop > Visualforce Pages
10. Click add
    * Fill the name
    * ```
<apex:page >
    <apex:canvasApp applicationName="testcanvas" scrolling="yes"/>
</apex:page>
    ```
11. Save