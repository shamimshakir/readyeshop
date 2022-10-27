<!DOCTYPE html>
<html lang="en" style="--theme-deafult:{{$companysetup[0]->themecolor}};">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"> 
    <?php
        $meta_name='';
        $meta_type='';
        $meta_content='';
        $meta_image='';       
        $fpart=Request::path();
        $ex=explode("/",$fpart);
        $fristpart=$ex[0];

        if($fristpart=='product'){
            if(count($products)>0){
                foreach($products as $product){
                   $product->pd_name;
                    $meta_name=$product->pd_name;
                    $meta_type=$product->meta_keyword;
                    $meta_content=$product->meta_description;
                    $meta_image=Request::getSchemeAndHttpHost().'/'.Request::getHttpHost().'/images/product/'.$product->pd_thumbnail;
                }
            }
           
        }elseif($fristpart=='category'){
           

        }else{
           foreach($metatags as $metatag) {
                $meta_name=$companysetup[0]->company_name.' |  '.$metatag->meta_name;
                $meta_type=$metatag->meta_type;
                $meta_content=$metatag->meta_content;
                $meta_image=$compurl.$companysetup[0]->logo;
            } 
        }

        $narray=array('facebook_msg' => '', 'facebook_ana' => '', 'google_ana' => '');
        foreach($fbmassengers as $fbmassenger) {
            $narray[$fbmassenger->name] = $fbmassenger->command;
        }


      
   ?>

     <!-- Basic HTML Meta Tags -->
    <meta name='pagename' content="{{$meta_name}}">
    <meta name='category' content="{{$meta_type}}">
    <meta name='subtitle' content="{{$meta_type}}">
    <meta name='subject' content="{{$meta_name}}"> 

    <title>{{$meta_name}}</title>

    <link rel="shortcut icon" href="{{$compurl}}{{$companysetup[0]->favicon}}">

    <meta name="description" content="{{$meta_type}}">
    <meta name="keywords" content="{{$meta_type}}">     
    <meta name='robots' content='index,follow'>
    <meta name='csrf-param' content='authenticity_token'>
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <meta name='copyright' content="{{$companysetup[0]->company_name}}">
    <meta name='language' content='EN'>
    <meta name='revised' content="{{date('l, F jS, Y, h:i a')}}">
    <meta name='abstract' content="{{$meta_type}}">
    <meta name='topic' content="{{$meta_name}}">
    <meta name='summary' content="{{$meta_type}}">
    <meta name='Classification' content='Business'>
    <meta name='author' content="{{$companysetup[0]->company_name}}, {{$companysetup[0]->contact_email}}">
    <meta name='designer' content=''>

    <meta name='reply-to' content="{{$companysetup[0]->contact_email}}">
    <meta name='owner' content="{{$companysetup[0]->company_name}}">
    <meta name='url' content='{{Request::getSchemeAndHttpHost()}}'>
    <meta name='identifier-URL' content='{{Request::getSchemeAndHttpHost()}}'>
    <meta name='directory' content='submission'>
    <meta name='syndication-source' content='{{Request::getSchemeAndHttpHost()}}'>
    <meta name='original-source' content='{{Request::getSchemeAndHttpHost()}}'>
    <meta name='coverage' content='Worldwide'>
    <meta name='distribution' content='Global'>
    <meta name='rating' content='General'>
    <meta name='revisit-after' content='7 days'>
    <meta name='target' content='all'>
    <meta name='HandheldFriendly' content='True'>
    <meta name='MobileOptimized' content='320'>
    <meta name='date' content='Sep. 27, 2010'>
    <meta name='search_date' content='2010-09-27'>
    <meta name='DC.title' content='Unstoppable Robot Ninja'>
    <meta name='ResourceLoaderDynamicStyles' content=''>
    <meta name='medium' content='blog'>
    <meta name='verify-v1' content='dV1r/ZJJdDEI++fKJ6iDEl6o+TMNtSu0kv18ONeqM0I='>
    <meta name='y_key' content='1e39c508e0d87750'>
    <meta name='pageKey' content='guest-home'>
    <meta itemprop='name' content='jQTouch'>
    <meta http-equiv='Expires' content='0'>
    <meta http-equiv='Pragma' content='cache'>
    <meta http-equiv='Cache-Control' content='cache'>
    <meta http-equiv='imagetoolbar' content='no'>
    <meta http-equiv='x-dns-prefetch-control' content='off'>

    <!-- OpenGraph Meta Tags -->
    <meta name='og:title' content="{{$meta_name}}">
    <meta name='og:type' content='website'>
    <meta name='og:url' content='{{Request::getSchemeAndHttpHost()}}'>
    <meta name='og:image' content='{{$meta_image}}'>
    <meta name='og:site_name' content='Ready Eshop'>
    <meta name='og:description' content="{{$meta_type}}">
    <meta name='fb:page_id' content='104039908362860'>
    <meta name='application-name' content='foursquare'>
    <meta name='og:email' content="{{$companysetup[0]->contact_email}}">
    <meta name='og:phone_number' content="{{$companysetup[0]->contact_phone}}">
    <meta name='og:fax_number' content="{{$companysetup[0]->contact_phone}}">
    <meta name='og:latitude' content='23.752654604333653'>
    <meta name='og:longitude' content='90.38279866048885'>
    <meta name='og:street-address' content="{{$companysetup[0]->comp_address}}">
    <meta name='og:locality' content='Panthapath'>
    <meta name='og:region' content='BN'>
    <meta name='og:postal-code' content='1205'>
    <meta name='og:country-name' content='Bangladesh'>
    <!-- Apple -->
    <meta name="apple-mobile-web-app-title" content="{{$meta_name}}"> <!-- New in iOS6 -->
    <meta name='apple-mobile-web-app-capable' content='yes'>
    <meta name='apple-touch-fullscreen' content='yes'>
    <meta name='apple-mobile-web-app-status-bar-style' content='black'>
    <meta name='format-detection' content='telephone=no'>
    <link href="{{$compurl}}{{$companysetup[0]->favicon}}" rel='apple-touch-icon' type='image/png'>
    <link href="{{$compurl}}{{$companysetup[0]->favicon}}" rel='apple-touch-icon' sizes='72x72'>
    <link href="{{$compurl}}{{$companysetup[0]->favicon}}" rel='apple-touch-icon' sizes='114x114'>
    <link href="{{$compurl}}{{$companysetup[0]->favicon}}" rel='apple-touch-startup-image'>
    <link href="{{$compurl}}{{$companysetup[0]->favicon}}" sizes='114x114' rel='apple-touch-icon-precomposed'>
    <link href="{{$compurl}}{{$companysetup[0]->favicon}}" sizes='72x72' rel='apple-touch-icon-precomposed'>
    <link href="{{$compurl}}{{$companysetup[0]->favicon}}" sizes='57x57' rel='apple-touch-icon-precomposed'>


    <!-- Internet Explorer Meta Tags -->

    <meta http-equiv='Page-Enter' content='RevealTrans(Duration=2.0,Transition=2)'>
    <meta http-equiv='Page-Exit' content='RevealTrans(Duration=3.0,Transition=12)'>
    <meta name='mssmarttagspreventparsing' content='true'>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible"/>
    <meta name='msapplication-starturl' content='{{Request::getSchemeAndHttpHost()}}/'>
    <meta name='msapplication-window' content='width=800;height=600'>
    <meta name='msapplication-navbutton-color' content='red'>
    <meta name='application-name' content='Ready Eshop'>
    <meta name='msapplication-tooltip' content='Ready Eshop'>
    <meta name='msapplication-task' content='name=About;action-uri=/about/;icon-uri=/images/about.ico'>
    <meta name='msapplication-task' content='name=The Big List;action-uri=/the-big-list-of-javascript-css-and-html-development-tools-libraries-projects-and-books/;icon-uri=/images/list_links.ico'>
    <meta name='msapplication-task' content='name=jQuery Posts;action-uri=/category/jquery/;icon-uri=/images/jquery.ico'>
    <meta name='msapplication-task' content='name=Start Developing;action-uri=/category/javascript/;icon-uri=/images/script.ico'>
    <meta name='msvalidate.01' content='6E3AD52DC176461A3C81DD6E98003BC9'>
    <meta http-equiv='cleartype' content='on'>

    <meta name='tweetmeme-title' content='Retweet Button Explained'>
    <meta name='blogcatalog'>

<!-- HTML Link Tags -->

    <link rel='alternate' type='application/rss+xml' title='RSS' href='{{Request::getSchemeAndHttpHost()}}'>
    <link rel='alternate' type='application/atom+xml' title='Atom 0.3' href='{{Request::getSchemeAndHttpHost()}}'>

    <link rel='me' type='text/html' href='http://google.com/profiles/nextechlimited'>
    <link rel='shortlink' href='{{Request::getSchemeAndHttpHost()}}/blog'>
    <link rel='archives' title='May 2003' href='{{Request::getSchemeAndHttpHost()}}/blog'>
    <link rel='index' title='DeWitt Clinton' href='{{Request::getSchemeAndHttpHost()}}/blog'>
    <link rel='start' title='Pattern Recognition 1' href='{{Request::getSchemeAndHttpHost()}}/blog'>
    <link rel='bookmark'title='Styleguide' href='{{Request::getSchemeAndHttpHost()}}/'>
    <link rel='search' href='{{Request::getSchemeAndHttpHost()}}/search.xml' type='application/opensearchdescription+xml' title='Viatropos'>
    <link rel='canonical' href='{{Request::getSchemeAndHttpHost()}}'>
    <link rel='pingback' href='{{Request::getSchemeAndHttpHost()}}'>
    <link rel='wlwmanifest' href='{{Request::getSchemeAndHttpHost()}}' type='application/wlwmanifest+xml'>


    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Yellowtail&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css" /> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" /> 
    <link href="{{ asset('css/frontend/app.css') }}" rel="stylesheet" type="text/css">
    <?php 
    
    
    if($narray['google_ana'] !=''){
        $ga_response=$narray['google_ana'];
    ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$ga_response}}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{$ga_response}}');
    </script>

    <?php 
        }
    
    if($narray['facebook_ana']!=''){
      $fa_response=  $narray['facebook_ana'];
    ?>
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{$fa_response}}');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{$fa_response}}&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
    <?php 
        }
    ?>
</head>
<body>

    <div id="wrapper"></div>
    <div class="tap-top top-cls" onclick="scrollToTop()">
      <div>
          <i class="fa fa-angle-double-up"></i>
      </div>
    </div>
   
    <script src="{{ mix('js/frontend/app.js') }}" type="text/javascript"></script>
    <script>
        function scrollToTop() {
          window.scroll({top: 0, left: 0, behavior: 'smooth'});
        }
    </script>
    <?php 
    
    
    if($narray['facebook_msg']!=''){
    ?>
    <div id="fb-root"></div>      
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v9.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution="setup_tool"
        page_id="{{$narray['facebook_msg']}}"
        theme_color="{{$companysetup[0]->themecolor}}">
      </div>
  <?php }?>
  <?php 
  $cssdata='';
  foreach($csses as $css) {
          $cssdata .= $css->item.':'.$css->item_value.'!important;} ';
        }

   
  ?>
<style>
    <?php 
        echo  $cssdata;  
    ?>
</style>
</body>
</html>
