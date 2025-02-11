import { ViewData } from "@kalel1500/laravel-ts-utils";
import TagsListUseCase from "../application/TagsListUseCase";
import { TagType } from "../../shared/domain/entities/TagType";

export type DataViewTags = {
    currentTagType: TagType|null;
    pluckedTypes: Record<string, string>;
}

export default class AdminController {
    tags(viewData: ViewData<DataViewTags>) {
        TagsListUseCase.new(viewData.data).__invoke();
    }
}
