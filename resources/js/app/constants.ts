import { Constants, DefaultConstants } from '@kalel1500/laravel-ts-utils';

interface AppConstants extends DefaultConstants {
    anotherSetting: string;
}

const constants = Constants.getInstance<AppConstants>();
constants.extend({
    VITE_APP_ENV:               import.meta.env.VITE_APP_ENV,
    VITE_APP_NAME:              import.meta.env.VITE_APP_NAME,
    VITE_APP_STORAGE_VERSION:   import.meta.env.VITE_APP_STORAGE_VERSION,
    anotherSetting:             'newCustomValue',
});

export const _const = <T extends keyof AppConstants>(key: T): AppConstants[T] => constants.get(key);
