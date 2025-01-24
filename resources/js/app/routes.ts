import { Route } from '@kalel1500/laravel-ts-utils';
import ExamplesController from '../src/infrastructure/ExamplesController';

export function defineRoutes(): void {
    Route.page('hexagonal.compareHtml', [ExamplesController, 'compareHtml']);
    Route.page('hexagonal.modifyCookie',[ExamplesController, 'modifyCookie']);
    Route.page('hexagonal.icons',       [ExamplesController, 'icons']);
}
