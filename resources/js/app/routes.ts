import { Route } from 'laravel-ts-utilities';
import ExamplesController from '../src/infrastructure/ExamplesController';

export function defineRoutes(): void {
    Route.page('hexagonal.compareHtml', [ExamplesController, 'compareHtml']);
}
