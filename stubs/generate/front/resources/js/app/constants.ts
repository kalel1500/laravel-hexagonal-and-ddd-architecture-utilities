import { Constants, DefaultConstants } from '@kalel1500/laravel-ts-utils';

interface AppConstants extends DefaultConstants {
    anotherSetting: string;
}

const constants = Constants.getInstance<AppConstants>();
constants.extend({
    appIcon:                    new URL('/resources/images/favicon.ico', import.meta.url).href,

    VITE_REVERB_APP_KEY:        import.meta.env.VITE_REVERB_APP_KEY,
    VITE_REVERB_HOST:           import.meta.env.VITE_REVERB_HOST,
    VITE_REVERB_PORT:           parseInt(import.meta.env.VITE_REVERB_PORT),
    VITE_REVERB_SCHEME:         import.meta.env.VITE_REVERB_SCHEME,

    VITE_BROADCASTING_ENABLED:  import.meta.env.VITE_BROADCASTING_ENABLED === 'true',
    VITE_APP_ENV:               import.meta.env.VITE_APP_ENV,
    VITE_APP_NAME:              import.meta.env.VITE_APP_NAME,
    VITE_APP_STORAGE_VERSION:   import.meta.env.VITE_APP_STORAGE_VERSION,
    anotherSetting:             'newCustomValue',
});

export const _const = <T extends keyof AppConstants>(key: T): AppConstants[T] => constants.get(key);
