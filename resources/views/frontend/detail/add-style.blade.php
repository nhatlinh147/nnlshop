<style>
    .section {
        width: 100%;
        margin-left: -15px;
        padding: 2px;
        padding-left: 15px;
        padding-right: 15px;
    }

    .title-attr {
        margin-top: 0;
        margin-bottom: 0;
    }

    div.section>div {
        width: 100%;
        display: inline-flex;
    }

    div.section a.tag-link {
        color: #6C757D;
        font-weight: 500;
        font-style: italic;
    }

    div.section>div>input {
        margin: 0;
        padding-left: 5px;
        font-size: 10px;
        padding-right: 5px;
        max-width: 18%;
        text-align: center;
    }

    .attr {
        cursor: pointer;
        margin: 5px;
        height: 40px;
        width: 40px;
        font-size: 12px;
        padding: 2px;
        border: 1px solid gray;
        border-radius: 2px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .attr.active {
        border: 4px solid #c4c3c394;
        border-radius: 4px;
        box-sizing: content-box;
    }

    table.fake-table tr td:first-child {
        font-weight: bold;
    }

    table.fake-table,
    table.fake-table tr,
    table.fake-table tr td,
    table.fake-table th {
        border: 2px solid rgba(112, 112, 112, 0.336);
        padding-left: 5px;
    }

    .image-header,
    .image-content {
        position: relative;
        text-align: center;
        padding: 10px 0px 20px;
    }
</style>
