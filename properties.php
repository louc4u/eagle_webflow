<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$token;
$curl = curl_init();
$webflowApiKey;

//field names
$name = "";
$description = "";
$category_listing = "";
$agents = "";
$location = "";
$state = "";
$postcodeValue = "";
$build_area = "";
$land_area = "";
$advertised_listing_price = "";
$listing_price = "";
$listing_category = "";
$property_type = "";
$longitude = "";
$latitude = "";
$all_images = array();
$imagesJSON = "";
$property_type = "";
$publish_items = array();
$suburb = "";
$description = "";
$createdAt = "";
$imageUrl = "";
$sold = "";
$recently_sold = "";
$edges = [];

$collectionId = 'Replace with your actual Webflow Collection ID'; 

deleteAllItems();


curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.eagleagent.com.au/api/v3/token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer Client_ID',
    'Cookie: Client_Secret'
  ),
));

$response = curl_exec($curl);

curl_close($curl);


//extract token
// Decode the JSON to a PHP associative array
$data = json_decode($response, true);

// Extract the token value
$token = $data['data']['token']['token'];



    function getProperties($Ptype, $token) {


            if($Ptype == 'ACTIVE') 
            {
                $query ='
                query GetProperties {
                  properties(listingType: COMMERCIAL, status: ['.$Ptype.'], limit:300, orderBy: UPDATED_AT_DESC) {
                    edges {
                      node {
                        advertisedPrice
                        createdAt
                        updatedAt
                        soldDate
                        agents{
                          id
                          name
                          email
                          phone
                          mobile
                        }
                        description
                        altToPrice
                        floorplans {
                          id
                          position
                          url
                        }
                        formattedAddress
                        id
                        images {
                          id
                          position
                          url
                        }
                        latitude
                        listingDetails {
                          ... on Commercial {
                            floorArea
                            floorAreaUnits
                            price
                            propertyName
                            propertyType
                            propertyType2
                            propertyType3
                          }
                        }
                        listingType
                        landSize
                        landSizeUnits
                        longitude
                        postcode{
                          ... on PostcodeAustralia {
                            id
                            postcode
                            state
                            suburb
                          }
                        }
                        price
                        saleOrLease
                        showPrice
                        status
                        thumbnailSquare
                      }
                    }
                    pageInfo {
                      endCursor
                      hasNextPage
                    }
                  }
                }
                ';
            } else {
                $query ='
                query GetProperties {
                  properties(listingType: COMMERCIAL, status: ['.$Ptype.'], limit:300, orderBy: UPDATED_AT_DESC) {
                    edges {
                      node {
                        advertisedPrice
                        createdAt
                        updatedAt
                        soldDate
                        agents{
                          id
                          name
                          email
                          phone
                          mobile
                        }
                        description
                        altToPrice
                        floorplans {
                          id
                          position
                          url
                        }
                        formattedAddress
                        id
                        images {
                          id
                          position
                          url
                        }
                        latitude
                        listingDetails {
                          ... on Commercial {
                            floorArea
                            floorAreaUnits
                            price
                            propertyName
                            propertyType
                            propertyType2
                            propertyType3
                          }
                        }
                        landSize
                        landSizeUnits
                        listingType
                        longitude
                        postcode{
                          ... on PostcodeAustralia {
                            id
                            postcode
                            state
                            suburb
                          }
                        }
                        price
                        saleOrLease
                        showPrice
                        status
                        thumbnailSquare
                      }
                    }
                    pageInfo {
                      endCursor
                      hasNextPage
                    }
                  }
                }
                ';
            }
        
            //echo 'token;'.$token;
            
            //Make the query to EAGLE CRM
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://www.eagleagent.com.au/api/v3/graphql',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
               CURLOPT_POSTFIELDS => json_encode(array('query' => $query)),
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$token,
                'Cookie: _eagle_session=CLIENT_SECRET'
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            
            return $response;
    }
    deleteAllItems();
    $props = '';
    $props = getProperties("ACTIVE", $token);
    $data = [];
    $data = json_decode($props, true);
    


    
    
    // Check if the decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Failed to decode JSON.');
    }
    
    // Access the "edges" array within the data
    $edges = $data['data']['properties']['edges'];
    
    
    

    // Decode the JSON data
    //$data = json_decode($totaldata, true);
    
    

        // Loop through the edges array
foreach ($edges as $edge) {
            $collectionId = 'Replace with your actual Webflow Collection ID'; 
             $all_images = array();
            // Access the "node" object within each edge
            $node = $edge['node'];
        
            // Access properties of the "node" object
            $advertised_listing_price = $node['advertisedPrice'];
            $agents = $node['agents'];
            
            // Loop through the agents array
    foreach ($agents as $agent) {
        // Access properties of each agent
        $agent_id = $agent['id'];
        $agent_name = $agent['name'];
        $agent_email = $agent['email'];
        $agent_phone = $agent['phone'];
        $agent_mobile = $agent['mobile'];

        // Perform operations with agent data as needed
        // For example, you can store agent data in an array
        $agent_data = [
            'id' => $agent_id,
            'name' => $agent_name,
            'email' => $agent_email,
            'phone' => $agent_phone,
            'mobile' => $agent_mobile,
        ];

        // Add the agent data to the all_agents array
        $all_agents[] = $agent_data;
    }
    
            $formattedAddress = $node['formattedAddress'];
            $description = '<p>'.$node['description'].'</p>';
            $description =  nl2br($description);
            $latitude = $node['latitude'];
            $longitude = $node['longitude'];
            $listing_price = $node['price'];
            $listing_category = $node['saleOrLease'];
            $status = $node['status'];
            $statusProp = $node['status'];
            $name = $formattedAddress;
            $sold = "no";
            $recently_sold = false;
            $new_location = $node['postcode']['suburb'];
            $createdAt = $node['createdAt'];
            $createdAtDate = date('Y-m-d', strtotime(substr($createdAt,0,10)));
            $updatedAt = $node['updatedAt'];
            $updatedAtDate = date('Y-m-d', strtotime(substr($updatedAt,0,10)));
            $soldDate = $node['soldDate'];
            $soldDateX = date('Y-m-d', strtotime(substr($soldDate,0,10)));
            
            
            
            if ($listing_category == "LEASE") {
                $category_listing = "Commercial Rental";
            }
            else if ($listing_category == "SALE_AND_LEASE") {
                $category_listing = "For Sale and Lease";
            }
            else
            {
                 $category_listing = "Commercial Sale";
            }
            
            if ($listing_category == "SALE_AND_LEASE") {
                $listing_category = "For Sale and Lease";
            }
            
            if ($status == "ACTIVE" || $status == "UNDER OFFER") {
                $sold = "no";
                $recently_sold = false;
            }
            else {
                $sold = "yes";
                $recently_sold = true;
            }
           
             
               
        
            $location_string = explode(',', $name);
            $location = $location_string[1];
            $location = strtolower($location);
            $location_u = ucfirst($location);
            $location_final = str_replace(' ', '', $location_u);
        
        
            // You can perform actions with the properties here
            // echo "Advertised Price: $advertised_listing_price<br>";
            // echo "Agents: "; print_r($agents); echo "<br>";
            // echo "Formatted Address: $formattedAddress<br>";
            // echo "Latitude: $latitude<br>";
            // echo "Longitude: $longitude<br>";
            // echo "Price: $listing_price<br>";
            // echo "Sale or Lease: $listing_category<br>";
            // echo "Status: $status<br>";
        
            // If you need to access more nested properties, you can do so here.
            // For example, to access the "listingDetails" object:
            $listingDetails = $node['listingDetails'];
            $build_area = $listingDetails['floorArea'];
            $land_area = $node['landSize'];
            $floorAreaUnits = $listingDetails['floorAreaUnits'];
           
            
            $property_type =  $listingDetails['propertyType'];
            $property_type = strtolower($property_type);
            $property_type = ucfirst($property_type);
            $property_type = str_replace('_', '/', $property_type);
        
            // To access the "postcode" object:
            $postcode = $node['postcode'];
            $postcodeId = $postcode['id'];
            $postcodeValue = $postcode['postcode'];
            
            // To access the "images" array:
            $images = $node['images'];
            $first_image;
            $count = 1;
            foreach ($images as $image) {
                $imageId = $image['id'];
                $imagePosition = $image['position'];
                if ($count == 1) {
                     $first_image = $image['url'];
                }
                $imageUrl = $image['url'];
                //echo "Image: $imageUrl<br>";
                $all_images[] = $imageUrl;
                $count++;
            }
            
           // $imagesJSON = json_encode($all_images);
            //$imagesJSON = str_replace('\\', '', json_encode($all_images));
            

// Assuming $all_images is your array of images
$imagesJSON = json_encode($all_images);

// Decode the JSON string
$imagesArray = json_decode($imagesJSON);

// Remove backslashes from each URL
$cleanedUrls = array_map(function($url) {
    return str_replace('\\', '', $url);
}, $imagesArray);

// Encode the cleaned URLs back to JSON
$cleanedImagesJSON = json_encode($cleanedUrls);
        
            /******************************************************************************/
            
             //add items to 
                if (!checkExists($name))
                {
                         
                        // Replace with your actual Webflow API key and site ID
                        $webflowApiKey = 'Replace with your actual Webflow API key';
                        $webflowSiteId = 'Replace with your actual Webflow Site ID';
                        
                        // API endpoint to add items to the collection
                        $endpoint = "https://api.webflow.com/collections/$collectionId/items";
                        
                        // JSON data representing the item to be added (modify this as per your collection schema)
                       $data = [
                            'fields' => [
                                "name" => $name,
                                "description" => $description,
                                "category-listing" => $category_listing,
                                "status" => $statusProp,
                                "state" => "WA",
                                "postcode" => strval($postcodeValue),
                                "build-area" => strval($build_area),
                                "land-area" => strval($land_area),
                                "advertised-listing-price" => $advertised_listing_price,
                                "listing-price" => $listing_price,
                                "listing-date" => $createdAtDate,
                                "updated-at" => $updatedAtDate,
                                "sold-date" => $soldDateX,
                                "sale-type" => $listing_category,
                                "property-type-2" => $property_type,
                                "location" =>  $new_location,
                                "longitude" => strval($latitude),
                                "latitude" => strval($longitude),
                                "sold" => $sold,
                                "recently-sold-or-leased" => $recently_sold,
                                "image-array" => $cleanedImagesJSON,
                                //"images-tilt" => $cleanedImagesJSON,
                                //"cover-image" => $first_image,
                                //"images" => $all_images,
                                "agent-name" => $agent_name, // Include agent's name
                                "agent-email" => $agent_email,
                                "agent-phone" => $agent_phone,
                                "agent-mobile" => $agent_mobile,
                               // "agent-name" => $agentx,
                                "_archived" => false,
                                "_draft" => false
                            ]
                        ];
                        

                        
                        // Convert the data to JSON format
                        $jsonData = json_encode($data);
                        
                        // Set up cURL to make the API request
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $endpoint);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Authorization: Bearer ' . $webflowApiKey,
                            'Content-Type: application/json',
                            'accept-version: 1.0.0',
                        ]);
                        
                        // Execute the cURL request
                       $response = curl_exec($ch);
                       echo "WEBFLOW RESPONSE";
                       print_r($response);
                       
                       
                        // Decode the JSON object into an associative array
                        $newdata = json_decode($response, true);
                        
                        // Access the _id property
                        $id = $newdata['_id'];
                        $publish_items[] = $id;
                        
                        // Check for errors
                        if (curl_errno($ch)) {
                            echo 'Error: ' . curl_error($ch);
                            // Handle the error as per your requirements
                        }
                        
                        // Close the cURL session
                        curl_close($ch);
                }
        
        }

/*****************************************************************************/

//publishItem($publish_items);
//publishSite();


/******************************************************************************/    


/******************************************************************************/


function publishItem($items) {
     $collectionId = 'Replace with your actual Webflow Collection ID'; 
     $webflowApiKey = "Replace with your actual Webflow API key";
    
    // Endpoint for triggering a full site publish
    $endpoint = "https://api.webflow.com/collections/$collectionId/items/publish";
    
    // Create an associative array with the property name and the original array
    $itemsArray = array(
        "itemIds" => $items
    );
        
    // Convert the data to JSON format
    $jsonData = json_encode($itemsArray);
    
    print_r($jsonData);
    
   // Set up cURL to make the API request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $webflowApiKey,
        'Content-Type: application/json',
        'accept-version: 1.0.0',
    ]);
    
    // Execute the cURL request
    $response = curl_exec($ch);
    echo "--------------PUBLISH RESPONSE --------------------------------------------";
    print_r($response);
    echo "--------------END PUBLISH RESPONSE --------------------------------------------";
    
    // Check for errors and handle the response as needed
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        echo 'Site published successfully!';
    }
    
    // Close the cURL session
    curl_close($ch);


}

function publishSite() {
     $collectionId = 'Replace with your actual Webflow Collection ID'; 
     $webflowApiKey = "Replace with your actual Webflow API key";
    
    // Endpoint for triggering a full site publish
    $endpoint = "https://api.webflow.com/sites/REPLACE_WITH_WEBFLOW_SITE_ID/publish";
    
    $sites = array("Replace with your actual Webflow Site NAME", "REPLACE_WITH_YOUR_DOMAIN_NAME");
    
    // Create an associative array with the property name and the original array
     $itemsArray = array(
        "domains" => $sites
    );
        
    // Convert the data to JSON format
    $jsonData = json_encode($itemsArray);
    
    print_r($jsonData);
    
   // Set up cURL to make the API request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $webflowApiKey,
        'Content-Type: application/json',
        'accept-version: 1.0.0',
    ]);
    
    // Execute the cURL request
    $response = curl_exec($ch);

    
    // Check for errors and handle the response as needed
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        echo 'Site published successfully!';
    }
    
    // Close the cURL session
    curl_close($ch);


}



function deleteItems($items) {
    $collectionId = 'Replace with your actual Webflow Collection ID'; 
    $webflowApiKey = "Replace with your actual Webflow API key";
    // Endpoint for triggering a full site publish
    $endpoint = "https://api.webflow.com/collections/$collectionId/items/";
    
    
        // Create an associative array with the property name and the original array
    $itemsArray = array(
        "itemIds" => $items
    );
        
    // Convert the data to JSON format
    $jsonData = json_encode($itemsArray);
    

    
   // Set up cURL to make the API request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $webflowApiKey,
        'Content-Type: application/json',
        'accept-version: 1.0.0',
    ]);
    
    // Execute the cURL request
    $response = curl_exec($ch);
    //print_r($response);
    
    // Check for errors and handle the response as needed
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        echo 'Items Deleted successfully!';
    }
    
    // Close the cURL session
    curl_close($ch);


}

function deleteAllItems() {
    $collectionId = 'Replace with your actual Webflow Collection ID'; 
    $delete_items = array();
       $webflowApiKey = "Replace with your actual Webflow API key";
    // Endpoint for triggering a full site publish
    $endpoint = "https://api.webflow.com/collections/$collectionId/items";
    

    
   // Set up cURL to make the API request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $webflowApiKey,
        'Content-Type: application/json',
        'accept-version: 1.0.0',
    ]);
    
    // Execute the cURL request
    $response = curl_exec($ch);
   // print_r($response);
    
    // Check for errors and handle the response as needed
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        echo 'Items fetched successfully!';
    }
    
    // Close the cURL session
    
    // Decode JSON data into a PHP array
    $allitems = json_decode($response, true);
    
     // Access the "edges" array within the data
    $items = $allitems['items'];
    
    //print_r($items);
    
    // Loop through the PHP array using foreach
    foreach ($items as $item) {
       $delete_items[] = $item['_id'];
    }
    deleteItems($delete_items);
    
   
        
}

// *********************************************************************************************************************************************************
   $props = '';
   $props = getProperties("LEASED", $token);
    $data2 = [];
    $data2 = json_decode($props, true);
    


    $edges = [];
    
    // Check if the decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Failed to decode JSON.');
    }
    // Access the "edges" array within the data
    $edges = $data2['data']['properties']['edges'];
    
    
    

    // Decode the JSON data
    //$data = json_decode($totaldata, true);
    
    

        // Loop through the edges array
foreach ($edges as $edge) {
            $collectionId = 'Replace with your actual Webflow Collection ID'; 
             $all_images = array();
            // Access the "node" object within each edge
            $node = $edge['node'];
        
            // Access properties of the "node" object
            $advertised_listing_price = $node['advertisedPrice'];
            $agents = $node['agents'];
            
            // Loop through the agents array
    foreach ($agents as $agent) {
        // Access properties of each agent
        $agent_id = $agent['id'];
        $agent_name = $agent['name'];
        $agent_email = $agent['email'];
        $agent_phone = $agent['phone'];
        $agent_mobile = $agent['mobile'];

        // Perform operations with agent data as needed
        // For example, you can store agent data in an array
        $agent_data = [
            'id' => $agent_id,
            'name' => $agent_name,
            'email' => $agent_email,
            'phone' => $agent_phone,
            'mobile' => $agent_mobile,
        ];

        // Add the agent data to the all_agents array
        $all_agents[] = $agent_data;
    }
    
            $formattedAddress = $node['formattedAddress'];
            $description = '<p>'.$node['description'].'</p>';
            $description =  nl2br($description);
            $latitude = $node['latitude'];
            $longitude = $node['longitude'];
            $listing_price = $node['price'];
            $listing_category = $node['saleOrLease'];
            $status = $node['status'];
            $statusProp = $node['status'];
            $name = $formattedAddress;
            $sold = "no";
            $recently_sold = false;
            $new_location = $node['postcode']['suburb'];
            $createdAt = $node['createdAt'];
            $createdAtDate = date('Y-m-d', strtotime(substr($createdAt,0,10)));
            $updatedAt = $node['updatedAt'];
            $updatedAtDate = date('Y-m-d', strtotime(substr($updatedAt,0,10)));
            $soldDate = $node['soldDate'];
            $soldDateX = date('Y-m-d', strtotime(substr($soldDate,0,10)));
            
             
            
            if ($listing_category == "LEASE") {
                $category_listing = "Commercial Rental";
            }
            else if ($listing_category == "SALE_AND_LEASE") {
                $category_listing = "For Sale and Lease";
            }
            else
            {
                 $category_listing = "Commercial Sale";
            }
            
            if ($listing_category == "SALE_AND_LEASE") {
                $listing_category = "For Sale and Lease";
            }
            
            if ($status == "ACTIVE" || $status == "UNDER OFFER") {
                $sold = "no";
                $recently_sold = false;
            }
            else {
                $sold = "yes";
                $recently_sold = true;
            }
           
             
               
        
            $location_string = explode(',', $name);
            $location = $location_string[1];
            $location = strtolower($location);
            $location_u = ucfirst($location);
            $location_final = str_replace(' ', '', $location_u);
        
        
            // You can perform actions with the properties here
            // echo "Advertised Price: $advertised_listing_price<br>";
            // echo "Agents: "; print_r($agents); echo "<br>";
            // echo "Formatted Address: $formattedAddress<br>";
            // echo "Latitude: $latitude<br>";
            // echo "Longitude: $longitude<br>";
            // echo "Price: $listing_price<br>";
            // echo "Sale or Lease: $listing_category<br>";
            // echo "Status: $status<br>";
        
            // If you need to access more nested properties, you can do so here.
            // For example, to access the "listingDetails" object:
            $listingDetails = $node['listingDetails'];
            $build_area = $listingDetails['floorArea'];
            $floorAreaUnits = $listingDetails['floorAreaUnits'];
            $land_area = $node['landSize'];
    
            
            $property_type =  $listingDetails['propertyType'];
            $property_type = strtolower($property_type);
            $property_type = ucfirst($property_type);
            $property_type = str_replace('_', '/', $property_type);
        
            // To access the "postcode" object:
            $postcode = $node['postcode'];
            $postcodeId = $postcode['id'];
            $postcodeValue = $postcode['postcode'];
            //$agent = $agents['agent'];
           // $agentx = $agent['name'];
            //echo "Postcode: $postcodeValue<br>";
            
            // To access the "images" array:
            $images = $node['images'];
            $first_image;
            $count = 1;
            foreach ($images as $image) {
                $imageId = $image['id'];
                $imagePosition = $image['position'];
                if ($count == 1) {
                     $first_image = $image['url'];
                }
                $imageUrl = $image['url'];
                //echo "Image: $imageUrl<br>";
                $all_images[] = $imageUrl;
                $count++;
            }
            
           // $imagesJSON = json_encode($all_images);
            //$imagesJSON = str_replace('\\', '', json_encode($all_images));
            // Assuming $all_images is your array of images
$imagesJSON = json_encode($all_images);

// Decode the JSON string
$imagesArray = json_decode($imagesJSON);

// Remove backslashes from each URL
$cleanedUrls = array_map(function($url) {
    return str_replace('\\', '', $url);
}, $imagesArray);

// Encode the cleaned URLs back to JSON
$cleanedImagesJSON = json_encode($cleanedUrls);
        
            /******************************************************************************/
            
             //add items to collection
                         
                        // Replace with your actual Webflow API key and site ID
                        $webflowApiKey = 'Replace with your actual Webflow API key';
                        $webflowSiteId = 'Replace with your actual Webflow Site ID';
                        
                        // API endpoint to add items to the collection
                        $endpoint = "https://api.webflow.com/collections/$collectionId/items";
                        
                        // JSON data representing the item to be added (modify this as per your collection schema)
                       $data = [
                            'fields' => [
                                "name" => $name,
                                "description" => $description,
                                "category-listing" => $category_listing,
                                "status" => $statusProp,
                                "listing-date" => $createdAtDate,
                                "updated-at" => $updatedAtDate,
                                "sold-date" => $soldDateX,
                                "state" => "WA",
                                "postcode" => strval($postcodeValue),
                                "build-area" => strval($build_area),
                                "land-area" => strval($land_area),
                                "advertised-listing-price" => $advertised_listing_price,
                                "listing-price" => $listing_price,
                                "listing-date" => $createdAtDate,
                                "sale-type" => $listing_category,
                                "property-type-2" => $property_type,
                                "location" =>  $new_location,
                                "longitude" => strval($latitude),
                                "latitude" => strval($longitude),
                                "sold" => $sold,
                                "recently-sold-or-leased" => $recently_sold,
                                "image-array" => $cleanedImagesJSON,
                                //"images-tilt" => $cleanedImagesJSON,
                               // "cover-image" => $first_image,
                               // "images" => $all_images,
                                "agent-name" => $agent_name, // Include agent's name
                                "agent-email" => $agent_email,
                                "agent-phone" => $agent_phone,
                                "agent-mobile" => $agent_mobile,
                               // "agent-name" => $agentx,
                                "_archived" => false,
                                "_draft" => false
                            ]
                        ];
                        
                        
                        // Convert the data to JSON format
                        $jsonData = json_encode($data);
                        
                        // Set up cURL to make the API request
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $endpoint);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Authorization: Bearer ' . $webflowApiKey,
                            'Content-Type: application/json',
                            'accept-version: 1.0.0',
                        ]);
                        
                        // Execute the cURL request
                       $response = curl_exec($ch);
                       echo "WEBFLOW RESPONSE";
                       print_r($response);
                       
                       
                        // Decode the JSON object into an associative array
                        $newdata = json_decode($response, true);
                        
                        // Access the _id property
                        $id = $newdata['_id'];
                        $publish_items[] = $id;
                        
                        // Check for errors
                        if (curl_errno($ch)) {
                            echo 'Error: ' . curl_error($ch);
                            // Handle the error as per your requirements
                        }
                        
                        // Close the cURL session
                        curl_close($ch);
        
        }
        
        // *********************************************************************************************************************************************************
   $props = '';
   $props = getProperties("SOLD", $token);
    $data3 = [];
    $data3 = json_decode($props, true);
    
    $edges = [];

    
    
    // Check if the decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Failed to decode JSON.');
    }
    // Access the "edges" array within the data
    $edges = $data3['data']['properties']['edges'];
    
    
    

    // Decode the JSON data
    //$data = json_decode($totaldata, true);
    
    

        // Loop through the edges array
foreach ($edges as $edge) {
            $collectionId = 'Replace with your actual Webflow Collection ID'; 
             $all_images = array();
            // Access the "node" object within each edge
            $node = $edge['node'];
        
            // Access properties of the "node" object
            $advertised_listing_price = $node['advertisedPrice'];
            $agents = $node['agents'];
            
            // Loop through the agents array
    foreach ($agents as $agent) {
        // Access properties of each agent
        $agent_id = $agent['id'];
        $agent_name = $agent['name'];
        $agent_email = $agent['email'];
        $agent_phone = $agent['phone'];
        $agent_mobile = $agent['mobile'];

        // Perform operations with agent data as needed
        // For example, you can store agent data in an array
        $agent_data = [
            'id' => $agent_id,
            'name' => $agent_name,
            'email' => $agent_email,
            'phone' => $agent_phone,
            'mobile' => $agent_mobile,
        ];

        // Add the agent data to the all_agents array
        $all_agents[] = $agent_data;
    }
    
    
            $formattedAddress = $node['formattedAddress'];
            $description = '<p>'.$node['description'].'</p>';
            $description =  nl2br($description);
            $latitude = $node['latitude'];
            $longitude = $node['longitude'];
            $listing_price = $node['price'];
            $listing_category = $node['saleOrLease'];
            $status = $node['status'];
            $statusProp = $node['status'];
            $name = $formattedAddress;
            $sold = "no";
            $recently_sold = false;
            $new_location = $node['postcode']['suburb'];
            $createdAt = $node['createdAt'];
            $createdAtDate = date('Y-m-d', strtotime(substr($createdAt,0,10)));
            $updatedAt = $node['updatedAt'];
            $updatedAtDate = date('Y-m-d', strtotime(substr($updatedAt,0,10)));
            $soldDate = $node['soldDate'];
            $soldDateX = date('Y-m-d', strtotime(substr($soldDate,0,10)));
            
             
            
            if ($listing_category == "LEASE") {
                $category_listing = "Commercial Rental";
            }
            else if ($listing_category == "SALE_AND_LEASE") {
                $category_listing = "For Sale and Lease";
            }
            else
            {
                 $category_listing = "Commercial Sale";
            }
            
            if ($listing_category == "SALE_AND_LEASE") {
                $listing_category = "For Sale and Lease";
            }
            
            if ($status == "ACTIVE" || $status == "UNDER OFFER") {
                $sold = "no";
                $recently_sold = false;
            }
            else {
                $sold = "yes";
                $recently_sold = true;
            }
           
             
               
        
            $location_string = explode(',', $name);
            $location = $location_string[1];
            $location = strtolower($location);
            $location_u = ucfirst($location);
            $location_final = str_replace(' ', '', $location_u);
        
        
            // You can perform actions with the properties here
            // echo "Advertised Price: $advertised_listing_price<br>";
            // echo "Agents: "; print_r($agents); echo "<br>";
            // echo "Formatted Address: $formattedAddress<br>";
            // echo "Latitude: $latitude<br>";
            // echo "Longitude: $longitude<br>";
            // echo "Price: $listing_price<br>";
            // echo "Sale or Lease: $listing_category<br>";
            // echo "Status: $status<br>";
        
            // If you need to access more nested properties, you can do so here.
            // For example, to access the "listingDetails" object:
            $listingDetails = $node['listingDetails'];
            $build_area = $listingDetails['floorArea'];
            $floorAreaUnits = $listingDetails['floorAreaUnits'];
            $land_area = $node['landSize'];
           
            
            $property_type =  $listingDetails['propertyType'];
            $property_type = strtolower($property_type);
            $property_type = ucfirst($property_type);
            $property_type = str_replace('_', '/', $property_type);
        
            // To access the "postcode" object:
            $postcode = $node['postcode'];
            $postcodeId = $postcode['id'];
            $postcodeValue = $postcode['postcode'];
            //$agent = $agents['agent'];
            //$agentx = $agent['name'];
            //echo "Postcode: $postcodeValue<br>";
            
            // To access the "images" array:
            $images = $node['images'];
            $first_image;
            $count = 1;
            foreach ($images as $image) {
                $imageId = $image['id'];
                $imagePosition = $image['position'];
                if ($count == 1) {
                     $first_image = $image['url'];
                }
                $imageUrl = $image['url'];
                //echo "Image: $imageUrl<br>";
                $all_images[] = $imageUrl;
                $count++;
            }
            
            //$imagesJSON = json_encode($all_images);
            //$imagesJSON = str_replace('\\', '', json_encode($all_images));
            // Assuming $all_images is your array of images
$imagesJSON = json_encode($all_images);

// Decode the JSON string
$imagesArray = json_decode($imagesJSON);

// Remove backslashes from each URL
$cleanedUrls = array_map(function($url) {
    return str_replace('\\', '', $url);
}, $imagesArray);

// Encode the cleaned URLs back to JSON
$cleanedImagesJSON = json_encode($cleanedUrls);
        
            /******************************************************************************/
            
             //add items to collection
                         
                        // Replace with your actual Webflow API key and site ID
                        $webflowApiKey = 'Replace with your actual Webflow API key';
                        $webflowSiteId = 'Replace with your actual Webflow Site ID';
                        
                        // API endpoint to add items to the collection
                        $endpoint = "https://api.webflow.com/collections/$collectionId/items";
                        
                        // JSON data representing the item to be added (modify this as per your collection schema)
                       $data = [
                            'fields' => [
                                "name" => $name,
                                "description" => $description,
                                "category-listing" => $category_listing,
                                "status" => $statusProp,
                                "listing-date" => $createdAtDate,
                                "updated-at" => $updatedAtDate,
                                "sold-date" => $soldDateX,
                                "state" => "WA",
                                "postcode" => strval($postcodeValue),
                                "build-area" => strval($build_area),
                                "land-area" => strval($land_area),
                                "advertised-listing-price" => $advertised_listing_price,
                                "listing-price" => $listing_price,
                                "listing-date" => $createdAtDate,
                                "sale-type" => $listing_category,
                                "property-type-2" => $property_type,
                                "location" =>  $new_location,
                                "longitude" => strval($latitude),
                                "latitude" => strval($longitude),
                                "sold" => $sold,
                                "recently-sold-or-leased" => $recently_sold,
                                "image-array" => $cleanedImagesJSON,
                                //"images-tilt" => $cleanedImagesJSON,
                                //"cover-image" => $first_image,
                                //"images" => $all_images,
                                "agent-name" => $agent_name, // Include agent's name
                                "agent-email" => $agent_email,
                                "agent-phone" => $agent_phone,
                                "agent-mobile" => $agent_mobile,
                                //"agent-name" => $agentx,
                                "_archived" => false,
                                "_draft" => false
                            ]
                        ];
                        
                        
                        // Convert the data to JSON format
                        $jsonData = json_encode($data);
                        
                        // Set up cURL to make the API request
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $endpoint);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Authorization: Bearer ' . $webflowApiKey,
                            'Content-Type: application/json',
                            'accept-version: 1.0.0',
                        ]);
                        
                        // Execute the cURL request
                       $response = curl_exec($ch);
                       echo "WEBFLOW RESPONSE";
                       print_r($response);
                       
                       
                        // Decode the JSON object into an associative array
                        $newdata = json_decode($response, true);
                        
                        // Access the _id property
                        $id = $newdata['_id'];
                        $publish_items[] = $id;
                        
                        // Check for errors
                        if (curl_errno($ch)) {
                            echo 'Error: ' . curl_error($ch);
                            // Handle the error as per your requirements
                        }
                        
                        // Close the cURL session
                        curl_close($ch);
        
        }
        
        
           // *********************************************************************************************************************************************************
   $props = '';
   $props = getProperties("UNDER_OFFER", $token);
    $data4 = [];
    $data4 = json_decode($props, true);
    
    $edges = [];

    
    
    // Check if the decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Failed to decode JSON.');
    }
    // Access the "edges" array within the data
    $edges = $data4['data']['properties']['edges'];
    
    
    

    // Decode the JSON data
    //$data = json_decode($totaldata, true);
    
    

        // Loop through the edges array
        foreach ($edges as $edge) {
            $collectionId = 'Replace with your actual Webflow Collection ID'; 
             $all_images = array();
            // Access the "node" object within each edge
            $node = $edge['node'];
        
            // Access properties of the "node" object
            $advertised_listing_price = $node['advertisedPrice'];
            $agents = $node['agents'];
            
            // Loop through the agents array
    foreach ($agents as $agent) {
        // Access properties of each agent
        $agent_id = $agent['id'];
        $agent_name = $agent['name'];
        $agent_email = $agent['email'];
        $agent_phone = $agent['phone'];
        $agent_mobile = $agent['mobile'];

        // Perform operations with agent data as needed
        // For example, you can store agent data in an array
        $agent_data = [
            'id' => $agent_id,
            'name' => $agent_name,
            'email' => $agent_email,
            'phone' => $agent_phone,
            'mobile' => $agent_mobile,
        ];

        // Add the agent data to the all_agents array
        $all_agents[] = $agent_data;
    }
    
    
            $formattedAddress = $node['formattedAddress'];
            $description = '<p>'.$node['description'].'</p>';
            $description =  nl2br($description);
            $latitude = $node['latitude'];
            $longitude = $node['longitude'];
            $listing_price = $node['price'];
            $listing_category = $node['saleOrLease'];
            $status = $node['status'];
            $statusProp = $node['status'];
            $name = $formattedAddress;
            $sold = "no";
            $recently_sold = false;
            $new_location = $node['postcode']['suburb'];
            $createdAt = $node['createdAt'];
            $createdAtDate = date('Y-m-d', strtotime(substr($createdAt,0,10)));
            $updatedAt = $node['updatedAt'];
            $updatedAtDate = date('Y-m-d', strtotime(substr($updatedAt,0,10)));
            $soldDate = $node['soldDate'];
            $soldDateX = date('Y-m-d', strtotime(substr($soldDate,0,10)));
            
             
            
            if ($listing_category == "LEASE") {
                $category_listing = "Commercial Rental";
            }
            else if ($listing_category == "SALE_AND_LEASE") {
                $category_listing = "For Sale and Lease";
            }
            else
            {
                 $category_listing = "Commercial Sale";
            }
            
            if ($listing_category == "SALE_AND_LEASE") {
                $listing_category = "For Sale and Lease";
            }
            
            if ($status == "ACTIVE" || $status == "UNDER OFFER") {
                $sold = "no";
                $recently_sold = false;
            }
            else {
                $sold = "yes";
                $recently_sold = true;
            }
           
             
               
        
            $location_string = explode(',', $name);
            $location = $location_string[1];
            $location = strtolower($location);
            $location_u = ucfirst($location);
            $location_final = str_replace(' ', '', $location_u);
        
        
            // You can perform actions with the properties here
            // echo "Advertised Price: $advertised_listing_price<br>";
            // echo "Agents: "; print_r($agents); echo "<br>";
            // echo "Formatted Address: $formattedAddress<br>";
            // echo "Latitude: $latitude<br>";
            // echo "Longitude: $longitude<br>";
            // echo "Price: $listing_price<br>";
            // echo "Sale or Lease: $listing_category<br>";
            // echo "Status: $status<br>";
        
            // If you need to access more nested properties, you can do so here.
            // For example, to access the "listingDetails" object:
            $listingDetails = $node['listingDetails'];
            $build_area = $listingDetails['floorArea'];
            $floorAreaUnits = $listingDetails['floorAreaUnits'];
            $land_area = $node['landSize'];
            
            
            $property_type =  $listingDetails['propertyType'];
            $property_type = strtolower($property_type);
            $property_type = ucfirst($property_type);
            $property_type = str_replace('_', '/', $property_type);
        
            // To access the "postcode" object:
            $postcode = $node['postcode'];
            $postcodeId = $postcode['id'];
            $postcodeValue = $postcode['postcode'];
           // $agent = $agents['agent'];
           // $agentx = $agent['name'];
            //echo "Postcode: $postcodeValue<br>";
            
            // To access the "images" array:
            $images = $node['images'];
            $first_image;
            $count = 1;
            foreach ($images as $image) {
                $imageId = $image['id'];
                $imagePosition = $image['position'];
                if ($count == 1) {
                     $first_image = $image['url'];
                }
                $imageUrl = $image['url'];
                //echo "Image: $imageUrl<br>";
                $all_images[] = $imageUrl;
                $count++;
            }
            
            //$imagesJSON = json_encode($all_images);
            //$imagesJSON = str_replace('\\', '', json_encode($all_images));
            // Assuming $all_images is your array of images
$imagesJSON = json_encode($all_images);

// Decode the JSON string
$imagesArray = json_decode($imagesJSON);

// Remove backslashes from each URL
$cleanedUrls = array_map(function($url) {
    return str_replace('\\', '', $url);
}, $imagesArray);

// Encode the cleaned URLs back to JSON
$cleanedImagesJSON = json_encode($cleanedUrls);
        
            /******************************************************************************/
            
             //add items to collection
                         
                        // Replace with your actual Webflow API key and site ID
                        $webflowApiKey = 'Replace with your actual Webflow API key';
                        $webflowSiteId = 'Replace with your actual Webflow Site ID';
                        
                        // API endpoint to add items to the collection
                        $endpoint = "https://api.webflow.com/collections/$collectionId/items";
                        
                        // JSON data representing the item to be added (modify this as per your collection schema)
                       $data = [
                            'fields' => [
                                "name" => $name,
                                "description" => $description,
                                "category-listing" => $category_listing,
                                "status" => $statusProp,
                                "listing-date" => $createdAtDate,
                                "updated-at" => $updatedAtDate,
                                "sold-date" => $soldDateX,
                                "state" => "WA",
                                "postcode" => strval($postcodeValue),
                                "build-area" => strval($build_area),
                                "land-area" => strval($land_area),
                                "advertised-listing-price" => $advertised_listing_price,
                                "listing-price" => $listing_price,
                                "listing-date" => $createdAtDate,
                                "sale-type" => $listing_category,
                                "property-type-2" => $property_type,
                                "location" =>  $new_location,
                                "longitude" => strval($latitude),
                                "latitude" => strval($longitude),
                                "sold" => $sold,
                                "recently-sold-or-leased" => $recently_sold,
                                "image-array" => $cleanedImagesJSON,
                                //"images-tilt" => $cleanedImagesJSON,
                                //"cover-image" => $first_image,
                               // "images" => $all_images,
                                "agent-name" => $agent_name, // Include agent's name
                                "agent-email" => $agent_email,
                                "agent-phone" => $agent_phone,
                                "agent-mobile" => $agent_mobile,
                               // "agent-name" => $agentx,
                                "_archived" => false,
                                "_draft" => false
                            ]
                        ];
                        
                        
                        // Convert the data to JSON format
                        $jsonData = json_encode($data);
                        
                        // Set up cURL to make the API request
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $endpoint);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Authorization: Bearer ' . $webflowApiKey,
                            'Content-Type: application/json',
                            'accept-version: 1.0.0',
                        ]);
                        
                        // Execute the cURL request
                       $response = curl_exec($ch);
                       echo "WEBFLOW RESPONSE";
                       print_r($response);
                       
                       
                        // Decode the JSON object into an associative array
                        $newdata = json_decode($response, true);
                        
                        // Access the _id property
                        $id = $newdata['_id'];
                        $publish_items[] = $id;
                        
                        // Check for errors
                        if (curl_errno($ch)) {
                            echo 'Error: ' . curl_error($ch);
                            // Handle the error as per your requirements
                        }
                        
                        // Close the cURL session
                        curl_close($ch);
        
        }
        
        publishSite();


    function checkExists($item_id_to_check) {
        
        $collectionId = 'Replace with your actual collection ID'; 
           // Replace with your actual Webflow API key and site ID
            $webflowApiKey = 'Replace with your actual Webflow API Key';
            $webflowSiteId = 'Replace with your actual site ID';
        // Make a request to the Webflow API to fetch collection items
        $api_url = "https://api.webflow.com/collections/$collectionId/items?api_version=1.0.0";
        $headers = [
            'Authorization: Bearer ' . $webflowApiKey,
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        // Check if the request was successful
        if ($response === false) {
            die('Error fetching data from Webflow API');
        }
        
        // Parse the JSON response
        $data = json_decode($response, true);
        
        // Check if the item with the specified ID exists in the collection
        $item_exists = false;
        
        foreach ($data['items'] as $item) {
            if ($item['name']  === $item_id_to_check) {
                $item_exists = true;
                break;
            }
        }
        
        if ($item_exists) {
            return true;
        } else {
           return false;
        }
    }
    
    

?>






