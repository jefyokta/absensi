import * as simpleDatatables from "simple-datatables";
if (
    document.getElementById("selection-table") &&
    typeof simpleDatatables.DataTable !== "undefined"
) {
    let multiSelect = true;
    let rowNavigation = false;
    let table = null;

    const resetTable = function () {
        if (table) {
            table.destroy();
        }

        const options = {
            rowRender: (row, tr, _index) => {
                if (!tr.attributes) {
                    tr.attributes = {};
                }
                if (!tr.attributes.class) {
                    tr.attributes.class = "";
                }
                if (row.selected) {
                    tr.attributes.class += " selected";
                } else {
                    tr.attributes.class = tr.attributes.class.replace(
                        " selected",
                        ""
                    );
                }
                return tr;
            },
        };
        if (rowNavigation) {
            options.rowNavigation = true;
            options.tabIndex = 1;
        }

        table = new simpleDatatables.DataTable("#selection-table", options);

        // Mark all rows as unselected
        table.data.data.forEach((data) => {
            data.selected = false;
        });

        table.on("datatable.selectrow", (rowIndex, event) => {
            event.preventDefault();
            const row = table.data.data[rowIndex];
            if (row.selected) {
                row.selected = false;
            } else {
                if (!multiSelect) {
                    table.data.data.forEach((data) => {
                        data.selected = false;
                    });
                }
                row.selected = true;
            }
            table.update();
        });
    };

    const isMobile = window.matchMedia("(any-pointer:coarse)").matches;
    if (isMobile) {
        rowNavigation = false;
    }

    resetTable();
}
