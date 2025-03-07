import { Route } from '@kalel1500/kalion-js';
import ExamplesController from '../src/infrastructure/ExamplesController';

export function defineRoutes(): void {
    Route.page('kalion.compareHtml', [ExamplesController, 'compareHtml']);
    Route.page('kalion.modifyCookie',[ExamplesController, 'modifyCookie']);
    Route.page('kalion.icons',       [ExamplesController, 'icons']);
}
