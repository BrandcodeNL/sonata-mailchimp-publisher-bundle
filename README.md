# sonata-mailchimp-publisher-bundle
Publish entities from sonata admin list view to Mailchimp campaigns

Sample config.yml
brandcode_nl_sonata_mailchimp_publisher:
    api_key: apiKey
      lists:
        mailchimp_list_id: 
            fromName: From name
            fromEmail:  from@email.com
            template: templateId
            format: email/mailchimp/news_format.html.twig  
            api_key: apiKey #optional to change api key per list
        mailchimp_list_id:
            fromName: From name
            fromEmail:  from@email.com
            template: templateId
            format: email/mailchimp/news_format.html.twig  
            api_key: apiKey #optional to change api key per list
