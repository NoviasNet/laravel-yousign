<?php

// config for Assiclick/Yousign
return [
    /*
     * Yousign API uses API keys to authenticate calls. You can manage those in your [Developer Dashboard](https://yousign.app/auth/settings/apikeys).
     */
    'api_key' => env('YOUSIGN_API_KEY'),

    /*
     * Yousign Enviroment (Sandbox or Production)
     *
     * https://api-sandbox.yousign.app/v3 (Sandbox)
     * https://api.yousign.app/v3 (Production)
     */
    'base_url' => env('YOUSIGN_BASE_URL', 'https://api-sandbox.yousign.app/v3'),

    /*
     * ID of the Branding to be used, found in your [Branding Dashboard](https://yousign.app/auth/settings/brandings)
     */
    'branding_id' => env('YOUSIGN_BRANDING_ID'),
];
