import 'flowbite';
import './constants';
import './translations';
import { EnvVariables, Route, UtilitiesServiceProvider } from '@kalel1500/laravel-ts-utils';
import { defineRoutes } from './routes';

// Declare .env variables
declare global {
    interface ImportMeta {
        readonly env: EnvVariables & {
            VITE_OTHER?: string
        };
    }
}

// Definir que acciones ejecutar del paquete
UtilitiesServiceProvider.features(['registerGlobalError', 'enableNotifications', 'startLayoutListeners']);

// Definimos y ejecutamos las rutas de JS
defineRoutes();
Route.dispatch();
