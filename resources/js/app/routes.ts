import { Route } from 'laravel-ts-utilities';
import TestController from '../src/home/infrastructure/TestController';

export function defineRoutes(): void {
    Route.page('hexagonal.test', [TestController, 'test']);
}
