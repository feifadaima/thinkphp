<table border="1">
    <tr>
        <th>id</th>
        <th>username</th>
        <th>password</th>
        <th>status</th>
        <th>caozuo</th>
    </tr>
    {volist name="user" id="aa"}
    <tr>
        <td>{$aa.id}</td>
        <td>{$aa.username}</td>
        <td>{$aa.password}</td>
        <td>{$aa.status}</td>
        <td>
            <a href="edit/id/{$aa.id}">编辑</a>
            <a href="del/id/{$aa.id}">删除</a>
        </td>
    </tr>
    {/volist}
</table>