import { Route } from '@kalel1500/laravel-ts-utils';
import DefaultController from '../src/shared/infrastructure/DefaultController';
import DashboardController from "../src/dashboard/infrastructure/DashboardController";

export function defineRoutes(): void {
    Route.page('home', [DefaultController, 'home']);
    Route.page('dashboard', [DashboardController, 'posts']);
}
