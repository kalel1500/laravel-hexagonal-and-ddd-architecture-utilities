import { Instantiable, TableSettingEvents, Ttable } from "@kalel1500/laravel-ts-utils";
import { DataViewTags } from "../infrastructure/AdminController";
import { route } from "ziggy-js";
import { CellEventCallback, Formatter, Options } from "tabulator-tables";

export default class TagsListUseCase extends  Instantiable
{
    protected ttable?: Ttable;
    protected readonly tableId: string = '#table-tags';
    protected readonly formatters: { [key: string]: Formatter };
    protected readonly cellClicks: { [key: string]: CellEventCallback };
    protected readonly viewData: DataViewTags;

    constructor(viewData: DataViewTags) {
        super();
        this.viewData = viewData;
        this.formatters = {};
        this.cellClicks = {};

    }

    __invoke()
    {
        console.log(this.viewData);
        const options: Options = {
            ...Ttable.defaultSettings,
            columnDefaults: {
                headerSort: true,
            },
            layout: "fitColumns",
            height: "70vh",
            pagination: false,
            ajaxURL: route("fetch.tags", this.viewData.currentTagType?.code),
            rowFormatter: row => {
                this.ttable!.addClassEditableOnEditableCells(row);
            },
            columns: [
                {title: "Id",       field: "id",            headerFilter: "input",  headerFilterParams: undefined,                                                          formatter: undefined,                   formatterParams: undefined,                                                                                                                                                 editable: false,                                                                                            },
                {title: "Nombre",   field: "name",          headerFilter: "input",  headerFilterParams: undefined,                                                          formatter: undefined,                   formatterParams: undefined,                                                         editor: "input",    editorParams: undefined,                                            editable: cell => this.ttable!.isEditableCell(cell),                                         },
                {title: "Código",   field: "code",          headerFilter: "input",  headerFilterParams: undefined,                                                          formatter: undefined,                   formatterParams: undefined,                                                         editor: "input",    editorParams: undefined,                                            editable: cell => this.ttable!.isEditableCell(cell),                                         },
                {title: "Tipo",     field: "tag_type_id",   headerFilter: "list",   headerFilterParams: Ttable.headerFilterParams_listSimple(this.viewData.pluckedTypes),   formatter: "lookup",                    formatterParams: Ttable.formatterParams_lookupSimple(this.viewData.pluckedTypes),   editor: "list",     editorParams: Ttable.editorParams_list(this.viewData.pluckedTypes), editable: cell => this.ttable!.isEditableCell(cell),                                         },
                {title: "Acciones",                                                                                                                                         formatter: this.formatters.cellActions,                                                                                     editor: undefined,  editorParams: undefined,                                            editable: false,                                                    cellClick: this.cellClicks.actions,     },
            ],
        };
        const events: TableSettingEvents = {
            tableBuilt: () => {
                const btnEdit = document.querySelector<HTMLButtonElement>("#btn-tag-edit");
                const btnCancelEdit = document.querySelector<HTMLButtonElement>("#btn-tag-cancel");
                const btnAdd = document.querySelector<HTMLButtonElement>("#btn-tag-add");
                btnEdit?.addEventListener("click", () => this.ttable!.defaultListenerBtnEdit(btnEdit, btnCancelEdit));
                btnCancelEdit?.addEventListener("click", () => this.ttable!.defaultListenerBtnCancel(btnEdit, btnCancelEdit));
                btnAdd?.addEventListener("click", () => this.ttable!.defaultListenerBtnAddRow());
            },
        };
        this.ttable = new Ttable(this.tableId, options, events);
    }
}
