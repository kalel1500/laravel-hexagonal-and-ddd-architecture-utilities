import HomeUseCase from '../application/HomeUseCase';

export default class DefaultController {
    home() {
        HomeUseCase.new().__invoke();
    }
}
