import { Route } from '@kalel1500/kalion-js';
import DefaultController from '../src/shared/infrastructure/DefaultController';
import DashboardController from "../src/dashboard/infrastructure/DashboardController";
import AdminController from "../src/admin/infrastructure/AdminController";

export function defineRoutes(): void {
    Route.page('home', [DefaultController, 'home']);
    Route.page('dashboard', [DashboardController, 'posts']);
    Route.page('tags', [AdminController, 'tags'], true);
}
