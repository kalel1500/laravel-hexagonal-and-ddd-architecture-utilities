import { Instantiable } from "@kalel1500/laravel-ts-utils";

export default class HomeUseCase extends Instantiable
{
    __invoke() {
        console.log('inicio');
    }
}
