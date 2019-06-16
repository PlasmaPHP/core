
window.projectVersion = 'master';

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:Plasma" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Plasma.html">Plasma</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Plasma_Types" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Plasma/Types.html">Types</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Plasma_Types_AbstractTypeExtension" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Plasma/Types/AbstractTypeExtension.html">AbstractTypeExtension</a>                    </div>                </li>                            <li data-name="class:Plasma_Types_TypeExtensionInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Plasma/Types/TypeExtensionInterface.html">TypeExtensionInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_Types_TypeExtensionResult" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Plasma/Types/TypeExtensionResult.html">TypeExtensionResult</a>                    </div>                </li>                            <li data-name="class:Plasma_Types_TypeExtensionResultInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Plasma/Types/TypeExtensionResultInterface.html">TypeExtensionResultInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_Types_TypeExtensionsManager" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Plasma/Types/TypeExtensionsManager.html">TypeExtensionsManager</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Plasma_AbstractColumnDefinition" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/AbstractColumnDefinition.html">AbstractColumnDefinition</a>                    </div>                </li>                            <li data-name="class:Plasma_Client" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/Client.html">Client</a>                    </div>                </li>                            <li data-name="class:Plasma_ClientInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/ClientInterface.html">ClientInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_ColumnDefinitionInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/ColumnDefinitionInterface.html">ColumnDefinitionInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_CommandInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/CommandInterface.html">CommandInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_CursorInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/CursorInterface.html">CursorInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_DriverFactoryInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/DriverFactoryInterface.html">DriverFactoryInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_DriverInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/DriverInterface.html">DriverInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_Exception" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/Exception.html">Exception</a>                    </div>                </li>                            <li data-name="class:Plasma_QueryBuilderInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/QueryBuilderInterface.html">QueryBuilderInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_QueryResult" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/QueryResult.html">QueryResult</a>                    </div>                </li>                            <li data-name="class:Plasma_QueryResultInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/QueryResultInterface.html">QueryResultInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_QueryableInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/QueryableInterface.html">QueryableInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_SQLQueryBuilderInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/SQLQueryBuilderInterface.html">SQLQueryBuilderInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_StatementInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/StatementInterface.html">StatementInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_StreamQueryResult" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/StreamQueryResult.html">StreamQueryResult</a>                    </div>                </li>                            <li data-name="class:Plasma_StreamQueryResultInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/StreamQueryResultInterface.html">StreamQueryResultInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_Transaction" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/Transaction.html">Transaction</a>                    </div>                </li>                            <li data-name="class:Plasma_TransactionException" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/TransactionException.html">TransactionException</a>                    </div>                </li>                            <li data-name="class:Plasma_TransactionInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/TransactionInterface.html">TransactionInterface</a>                    </div>                </li>                            <li data-name="class:Plasma_Utility" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Plasma/Utility.html">Utility</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Plasma.html", "name": "Plasma", "doc": "Namespace Plasma"},{"type": "Namespace", "link": "Plasma/Types.html", "name": "Plasma\\Types", "doc": "Namespace Plasma\\Types"},
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/ClientInterface.html", "name": "Plasma\\ClientInterface", "doc": "&quot;The client interface for plasma clients, responsible for creating drivers and pooling.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\ClientInterface", "fromLink": "Plasma/ClientInterface.html", "link": "Plasma/ClientInterface.html#method_create", "name": "Plasma\\ClientInterface::create", "doc": "&quot;Creates a client with the specified factory and options.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ClientInterface", "fromLink": "Plasma/ClientInterface.html", "link": "Plasma/ClientInterface.html#method_getConnectionCount", "name": "Plasma\\ClientInterface::getConnectionCount", "doc": "&quot;Get the amount of connections.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ClientInterface", "fromLink": "Plasma/ClientInterface.html", "link": "Plasma/ClientInterface.html#method_checkinConnection", "name": "Plasma\\ClientInterface::checkinConnection", "doc": "&quot;Checks a connection back in, if usable and not closing.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ClientInterface", "fromLink": "Plasma/ClientInterface.html", "link": "Plasma/ClientInterface.html#method_beginTransaction", "name": "Plasma\\ClientInterface::beginTransaction", "doc": "&quot;Begins a transaction. Resolves with a &lt;code&gt;TransactionInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ClientInterface", "fromLink": "Plasma/ClientInterface.html", "link": "Plasma/ClientInterface.html#method_close", "name": "Plasma\\ClientInterface::close", "doc": "&quot;Closes all connections gracefully after processing all outstanding requests.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ClientInterface", "fromLink": "Plasma/ClientInterface.html", "link": "Plasma/ClientInterface.html#method_quit", "name": "Plasma\\ClientInterface::quit", "doc": "&quot;Forcefully closes the connection, without waiting for any outstanding requests. This will reject all outstanding requests.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ClientInterface", "fromLink": "Plasma/ClientInterface.html", "link": "Plasma/ClientInterface.html#method_runCommand", "name": "Plasma\\ClientInterface::runCommand", "doc": "&quot;Runs the given command.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ClientInterface", "fromLink": "Plasma/ClientInterface.html", "link": "Plasma/ClientInterface.html#method_createReadCursor", "name": "Plasma\\ClientInterface::createReadCursor", "doc": "&quot;Creates a new cursor to seek through SELECT query results. Resolves with a &lt;code&gt;CursorInterface&lt;\/code&gt; instance.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/ColumnDefinitionInterface.html", "name": "Plasma\\ColumnDefinitionInterface", "doc": "&quot;This interface defines a common column definition abstraction.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_getDatabaseName", "name": "Plasma\\ColumnDefinitionInterface::getDatabaseName", "doc": "&quot;Get the database name this column is in.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_getTableName", "name": "Plasma\\ColumnDefinitionInterface::getTableName", "doc": "&quot;Get the table name this column is in.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_getName", "name": "Plasma\\ColumnDefinitionInterface::getName", "doc": "&quot;Get the column name.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_getType", "name": "Plasma\\ColumnDefinitionInterface::getType", "doc": "&quot;Get the type name, such as &lt;code&gt;BIGINT&lt;\/code&gt;, &lt;code&gt;VARCHAR&lt;\/code&gt;, etc.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_getCharset", "name": "Plasma\\ColumnDefinitionInterface::getCharset", "doc": "&quot;Get the charset, such as &lt;code&gt;utf8mb4&lt;\/code&gt;.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_getLength", "name": "Plasma\\ColumnDefinitionInterface::getLength", "doc": "&quot;Get the maximum field length, if any.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_isNullable", "name": "Plasma\\ColumnDefinitionInterface::isNullable", "doc": "&quot;Whether the column is nullable (not &lt;code&gt;NOT NULL&lt;\/code&gt;).&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_isAutoIncrement", "name": "Plasma\\ColumnDefinitionInterface::isAutoIncrement", "doc": "&quot;Whether the column is auto incremented.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_isPrimaryKey", "name": "Plasma\\ColumnDefinitionInterface::isPrimaryKey", "doc": "&quot;Whether the column is the primary key.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_isUniqueKey", "name": "Plasma\\ColumnDefinitionInterface::isUniqueKey", "doc": "&quot;Whether the column is the unique key.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_isMultipleKey", "name": "Plasma\\ColumnDefinitionInterface::isMultipleKey", "doc": "&quot;Whether the column is part of a multiple\/composite key.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_isUnsigned", "name": "Plasma\\ColumnDefinitionInterface::isUnsigned", "doc": "&quot;Whether the column is unsigned (only makes sense for numeric types).&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_isZerofilled", "name": "Plasma\\ColumnDefinitionInterface::isZerofilled", "doc": "&quot;Whether the column gets zerofilled to the length.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_getFlags", "name": "Plasma\\ColumnDefinitionInterface::getFlags", "doc": "&quot;Get the column flags.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_getDecimals", "name": "Plasma\\ColumnDefinitionInterface::getDecimals", "doc": "&quot;Get the maximum shown decimal digits.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\ColumnDefinitionInterface", "fromLink": "Plasma/ColumnDefinitionInterface.html", "link": "Plasma/ColumnDefinitionInterface.html#method_parseValue", "name": "Plasma\\ColumnDefinitionInterface::parseValue", "doc": "&quot;Parses the row value into the field type.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/CommandInterface.html", "name": "Plasma\\CommandInterface", "doc": "&quot;The basic interface for commands. Some drivers may extend this interface to provide additional functionalities.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\CommandInterface", "fromLink": "Plasma/CommandInterface.html", "link": "Plasma/CommandInterface.html#method_getEncodedMessage", "name": "Plasma\\CommandInterface::getEncodedMessage", "doc": "&quot;Get the encoded message for writing to the database connection.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\CommandInterface", "fromLink": "Plasma/CommandInterface.html", "link": "Plasma/CommandInterface.html#method_onComplete", "name": "Plasma\\CommandInterface::onComplete", "doc": "&quot;Sets the command as completed. This state gets reported back to the user.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\CommandInterface", "fromLink": "Plasma/CommandInterface.html", "link": "Plasma/CommandInterface.html#method_onError", "name": "Plasma\\CommandInterface::onError", "doc": "&quot;Sets the command as errored. This state gets reported back to the user.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\CommandInterface", "fromLink": "Plasma/CommandInterface.html", "link": "Plasma/CommandInterface.html#method_onNext", "name": "Plasma\\CommandInterface::onNext", "doc": "&quot;Sends the next received value into the command.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\CommandInterface", "fromLink": "Plasma/CommandInterface.html", "link": "Plasma/CommandInterface.html#method_hasFinished", "name": "Plasma\\CommandInterface::hasFinished", "doc": "&quot;Whether the command has finished.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\CommandInterface", "fromLink": "Plasma/CommandInterface.html", "link": "Plasma/CommandInterface.html#method_waitForCompletion", "name": "Plasma\\CommandInterface::waitForCompletion", "doc": "&quot;Whether this command sets the connection as busy.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/CursorInterface.html", "name": "Plasma\\CursorInterface", "doc": "&quot;The cursor interface describes how a cursor can be accessed to fetch rows\nfrom the server interactively.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\CursorInterface", "fromLink": "Plasma/CursorInterface.html", "link": "Plasma/CursorInterface.html#method_isClosed", "name": "Plasma\\CursorInterface::isClosed", "doc": "&quot;Whether the cursor has been closed.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\CursorInterface", "fromLink": "Plasma/CursorInterface.html", "link": "Plasma/CursorInterface.html#method_close", "name": "Plasma\\CursorInterface::close", "doc": "&quot;Closes the cursor and frees the associated resources on the server.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\CursorInterface", "fromLink": "Plasma/CursorInterface.html", "link": "Plasma/CursorInterface.html#method_fetch", "name": "Plasma\\CursorInterface::fetch", "doc": "&quot;Fetches the given amount of rows using the cursor. Resolves with the row, an array of rows (if amount &gt; 1), or false if no more results exist.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/DriverFactoryInterface.html", "name": "Plasma\\DriverFactoryInterface", "doc": "&quot;A driver factory is used to create new driver instances. The factory is responsible to create the drivers with the necessary arguments.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\DriverFactoryInterface", "fromLink": "Plasma/DriverFactoryInterface.html", "link": "Plasma/DriverFactoryInterface.html#method_createDriver", "name": "Plasma\\DriverFactoryInterface::createDriver", "doc": "&quot;Creates a new driver instance.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/DriverInterface.html", "name": "Plasma\\DriverInterface", "doc": "&quot;The minimum public API a driver has to maintain. The driver MUST emit a &lt;code&gt;close&lt;\/code&gt; event when it gets disconnected from the server.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_getConnectionState", "name": "Plasma\\DriverInterface::getConnectionState", "doc": "&quot;Retrieves the current connection state.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_getBusyState", "name": "Plasma\\DriverInterface::getBusyState", "doc": "&quot;Retrieves the current busy state.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_getBacklogLength", "name": "Plasma\\DriverInterface::getBacklogLength", "doc": "&quot;Get the length of the driver backlog queue.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_connect", "name": "Plasma\\DriverInterface::connect", "doc": "&quot;Connects to the given URI.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_close", "name": "Plasma\\DriverInterface::close", "doc": "&quot;Closes all connections gracefully after processing all outstanding requests.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_quit", "name": "Plasma\\DriverInterface::quit", "doc": "&quot;Forcefully closes the connection, without waiting for any outstanding requests. This will reject all outstanding requests.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_isInTransaction", "name": "Plasma\\DriverInterface::isInTransaction", "doc": "&quot;Whether this driver is currently in a transaction.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_query", "name": "Plasma\\DriverInterface::query", "doc": "&quot;Executes a plain query. Resolves with a &lt;code&gt;QueryResultInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_prepare", "name": "Plasma\\DriverInterface::prepare", "doc": "&quot;Prepares a query. Resolves with a &lt;code&gt;StatementInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_execute", "name": "Plasma\\DriverInterface::execute", "doc": "&quot;Prepares and executes a query. Resolves with a &lt;code&gt;QueryResultInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_quote", "name": "Plasma\\DriverInterface::quote", "doc": "&quot;Quotes the string for use in the query.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_beginTransaction", "name": "Plasma\\DriverInterface::beginTransaction", "doc": "&quot;Begins a transaction. Resolves with a &lt;code&gt;TransactionInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_endTransaction", "name": "Plasma\\DriverInterface::endTransaction", "doc": "&quot;Informationally closes a transaction. This method is used by &lt;code&gt;Transaction&lt;\/code&gt; to inform the driver of the end of the transaction.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_runCommand", "name": "Plasma\\DriverInterface::runCommand", "doc": "&quot;Runs the given command.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_runQuery", "name": "Plasma\\DriverInterface::runQuery", "doc": "&quot;Runs the given querybuilder.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\DriverInterface", "fromLink": "Plasma/DriverInterface.html", "link": "Plasma/DriverInterface.html#method_createReadCursor", "name": "Plasma\\DriverInterface::createReadCursor", "doc": "&quot;Creates a new cursor to seek through SELECT query results. Resolves with a &lt;code&gt;CursorInterface&lt;\/code&gt; instance.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/QueryBuilderInterface.html", "name": "Plasma\\QueryBuilderInterface", "doc": "&quot;Represents a querybuilder.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\QueryBuilderInterface", "fromLink": "Plasma/QueryBuilderInterface.html", "link": "Plasma/QueryBuilderInterface.html#method_create", "name": "Plasma\\QueryBuilderInterface::create", "doc": "&quot;Creates a new instance of the querybuilder.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryBuilderInterface", "fromLink": "Plasma/QueryBuilderInterface.html", "link": "Plasma/QueryBuilderInterface.html#method_getQuery", "name": "Plasma\\QueryBuilderInterface::getQuery", "doc": "&quot;Returns the query.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryBuilderInterface", "fromLink": "Plasma/QueryBuilderInterface.html", "link": "Plasma/QueryBuilderInterface.html#method_getParameters", "name": "Plasma\\QueryBuilderInterface::getParameters", "doc": "&quot;Returns the associated parameters for the query.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/QueryResultInterface.html", "name": "Plasma\\QueryResultInterface", "doc": "&quot;This is just a basic interface. There is an additional interface which defines that the query result is stream-based.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\QueryResultInterface", "fromLink": "Plasma/QueryResultInterface.html", "link": "Plasma/QueryResultInterface.html#method_getAffectedRows", "name": "Plasma\\QueryResultInterface::getAffectedRows", "doc": "&quot;Get the number of affected rows (for UPDATE, DELETE, etc.).&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryResultInterface", "fromLink": "Plasma/QueryResultInterface.html", "link": "Plasma/QueryResultInterface.html#method_getWarningsCount", "name": "Plasma\\QueryResultInterface::getWarningsCount", "doc": "&quot;Get the number of warnings sent by the server.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryResultInterface", "fromLink": "Plasma/QueryResultInterface.html", "link": "Plasma/QueryResultInterface.html#method_getInsertID", "name": "Plasma\\QueryResultInterface::getInsertID", "doc": "&quot;Get the used insert ID for the row, if any. &lt;code&gt;INSERT&lt;\/code&gt; statements only.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryResultInterface", "fromLink": "Plasma/QueryResultInterface.html", "link": "Plasma/QueryResultInterface.html#method_getFieldDefinitions", "name": "Plasma\\QueryResultInterface::getFieldDefinitions", "doc": "&quot;Get the field definitions, if any. &lt;code&gt;SELECT&lt;\/code&gt; statements only.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryResultInterface", "fromLink": "Plasma/QueryResultInterface.html", "link": "Plasma/QueryResultInterface.html#method_getRows", "name": "Plasma\\QueryResultInterface::getRows", "doc": "&quot;Get the rows, if any. &lt;code&gt;SELECT&lt;\/code&gt; statements only.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/QueryableInterface.html", "name": "Plasma\\QueryableInterface", "doc": "&quot;Any queryable class (can execute queries) implements this indirectly or directly.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\QueryableInterface", "fromLink": "Plasma/QueryableInterface.html", "link": "Plasma/QueryableInterface.html#method_query", "name": "Plasma\\QueryableInterface::query", "doc": "&quot;Executes a plain query. Resolves with a &lt;code&gt;QueryResultInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryableInterface", "fromLink": "Plasma/QueryableInterface.html", "link": "Plasma/QueryableInterface.html#method_prepare", "name": "Plasma\\QueryableInterface::prepare", "doc": "&quot;Prepares a query. Resolves with a &lt;code&gt;StatementInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryableInterface", "fromLink": "Plasma/QueryableInterface.html", "link": "Plasma/QueryableInterface.html#method_execute", "name": "Plasma\\QueryableInterface::execute", "doc": "&quot;Prepares and executes a query. Resolves with a &lt;code&gt;QueryResultInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryableInterface", "fromLink": "Plasma/QueryableInterface.html", "link": "Plasma/QueryableInterface.html#method_runQuery", "name": "Plasma\\QueryableInterface::runQuery", "doc": "&quot;Runs the given querybuilder on an underlying driver instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryableInterface", "fromLink": "Plasma/QueryableInterface.html", "link": "Plasma/QueryableInterface.html#method_quote", "name": "Plasma\\QueryableInterface::quote", "doc": "&quot;Quotes the string for use in the query.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/SQLQueryBuilderInterface.html", "name": "Plasma\\SQLQueryBuilderInterface", "doc": "&quot;Represents a SQL querybuilder.&quot;"},
                    
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/StatementInterface.html", "name": "Plasma\\StatementInterface", "doc": "&quot;Represents any prepared statement.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\StatementInterface", "fromLink": "Plasma/StatementInterface.html", "link": "Plasma/StatementInterface.html#method_getID", "name": "Plasma\\StatementInterface::getID", "doc": "&quot;Get the driver-dependent ID of this statement.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\StatementInterface", "fromLink": "Plasma/StatementInterface.html", "link": "Plasma/StatementInterface.html#method_getQuery", "name": "Plasma\\StatementInterface::getQuery", "doc": "&quot;Get the prepared query.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\StatementInterface", "fromLink": "Plasma/StatementInterface.html", "link": "Plasma/StatementInterface.html#method_isClosed", "name": "Plasma\\StatementInterface::isClosed", "doc": "&quot;Whether the statement has been closed.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\StatementInterface", "fromLink": "Plasma/StatementInterface.html", "link": "Plasma/StatementInterface.html#method_close", "name": "Plasma\\StatementInterface::close", "doc": "&quot;Closes the prepared statement and frees the associated resources on the server.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\StatementInterface", "fromLink": "Plasma/StatementInterface.html", "link": "Plasma/StatementInterface.html#method_execute", "name": "Plasma\\StatementInterface::execute", "doc": "&quot;Executes the prepared statement. Resolves with a &lt;code&gt;QueryResult&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\StatementInterface", "fromLink": "Plasma/StatementInterface.html", "link": "Plasma/StatementInterface.html#method_runQuery", "name": "Plasma\\StatementInterface::runQuery", "doc": "&quot;Runs the given querybuilder on an underlying driver instance.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/StreamQueryResultInterface.html", "name": "Plasma\\StreamQueryResultInterface", "doc": "&quot;This is the more advanced query result interface, which is event based.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\StreamQueryResultInterface", "fromLink": "Plasma/StreamQueryResultInterface.html", "link": "Plasma/StreamQueryResultInterface.html#method_all", "name": "Plasma\\StreamQueryResultInterface::all", "doc": "&quot;Buffers all rows and returns a promise which resolves with an instance of &lt;code&gt;QueryResultInterface&lt;\/code&gt;.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/TransactionInterface.html", "name": "Plasma\\TransactionInterface", "doc": "&quot;Transactions turn off auto-commit mode and let you rollback any changes you have done during it.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\TransactionInterface", "fromLink": "Plasma/TransactionInterface.html", "link": "Plasma/TransactionInterface.html#method___destruct", "name": "Plasma\\TransactionInterface::__destruct", "doc": "&quot;Destructor. Implicit rollback and automatically checks the connection back into the client on deallocation.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\TransactionInterface", "fromLink": "Plasma/TransactionInterface.html", "link": "Plasma/TransactionInterface.html#method_getIsolationLevel", "name": "Plasma\\TransactionInterface::getIsolationLevel", "doc": "&quot;Get the isolation level for this transaction.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\TransactionInterface", "fromLink": "Plasma/TransactionInterface.html", "link": "Plasma/TransactionInterface.html#method_isActive", "name": "Plasma\\TransactionInterface::isActive", "doc": "&quot;Whether the transaction is still active, or has been committed\/rolled back.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\TransactionInterface", "fromLink": "Plasma/TransactionInterface.html", "link": "Plasma/TransactionInterface.html#method_commit", "name": "Plasma\\TransactionInterface::commit", "doc": "&quot;Commits the changes.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\TransactionInterface", "fromLink": "Plasma/TransactionInterface.html", "link": "Plasma/TransactionInterface.html#method_rollback", "name": "Plasma\\TransactionInterface::rollback", "doc": "&quot;Rolls back the changes.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\TransactionInterface", "fromLink": "Plasma/TransactionInterface.html", "link": "Plasma/TransactionInterface.html#method_createSavepoint", "name": "Plasma\\TransactionInterface::createSavepoint", "doc": "&quot;Creates a savepoint with the given identifier.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\TransactionInterface", "fromLink": "Plasma/TransactionInterface.html", "link": "Plasma/TransactionInterface.html#method_rollbackTo", "name": "Plasma\\TransactionInterface::rollbackTo", "doc": "&quot;Rolls back to the savepoint with the given identifier.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\TransactionInterface", "fromLink": "Plasma/TransactionInterface.html", "link": "Plasma/TransactionInterface.html#method_releaseSavepoint", "name": "Plasma\\TransactionInterface::releaseSavepoint", "doc": "&quot;Releases the savepoint with the given identifier.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma\\Types", "fromLink": "Plasma/Types.html", "link": "Plasma/Types/TypeExtensionInterface.html", "name": "Plasma\\Types\\TypeExtensionInterface", "doc": "&quot;A Type Extension is used to map database values (text\/binary) to and from PHP values.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionInterface", "fromLink": "Plasma/Types/TypeExtensionInterface.html", "link": "Plasma/Types/TypeExtensionInterface.html#method_canHandleType", "name": "Plasma\\Types\\TypeExtensionInterface::canHandleType", "doc": "&quot;Whether the type extension can handle the conversion of the passed value.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionInterface", "fromLink": "Plasma/Types/TypeExtensionInterface.html", "link": "Plasma/Types/TypeExtensionInterface.html#method_getHumanType", "name": "Plasma\\Types\\TypeExtensionInterface::getHumanType", "doc": "&quot;Get the human-readable type this Type Extension is for.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionInterface", "fromLink": "Plasma/Types/TypeExtensionInterface.html", "link": "Plasma/Types/TypeExtensionInterface.html#method_encode", "name": "Plasma\\Types\\TypeExtensionInterface::encode", "doc": "&quot;Encodes a PHP value into a (binary) database value.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionInterface", "fromLink": "Plasma/Types/TypeExtensionInterface.html", "link": "Plasma/Types/TypeExtensionInterface.html#method_decode", "name": "Plasma\\Types\\TypeExtensionInterface::decode", "doc": "&quot;Decodes a (binary) database value into a PHP value.&quot;"},
            
            {"type": "Interface", "fromName": "Plasma\\Types", "fromLink": "Plasma/Types.html", "link": "Plasma/Types/TypeExtensionResultInterface.html", "name": "Plasma\\Types\\TypeExtensionResultInterface", "doc": "&quot;Represents a successful encoding conversion as general interface.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionResultInterface", "fromLink": "Plasma/Types/TypeExtensionResultInterface.html", "link": "Plasma/Types/TypeExtensionResultInterface.html#method_getDatabaseType", "name": "Plasma\\Types\\TypeExtensionResultInterface::getDatabaseType", "doc": "&quot;Get the database type.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionResultInterface", "fromLink": "Plasma/Types/TypeExtensionResultInterface.html", "link": "Plasma/Types/TypeExtensionResultInterface.html#method_isUnsigned", "name": "Plasma\\Types\\TypeExtensionResultInterface::isUnsigned", "doc": "&quot;Whether it&#039;s unsigned.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionResultInterface", "fromLink": "Plasma/Types/TypeExtensionResultInterface.html", "link": "Plasma/Types/TypeExtensionResultInterface.html#method_getValue", "name": "Plasma\\Types\\TypeExtensionResultInterface::getValue", "doc": "&quot;Get the encoded value.&quot;"},
            
            
            {"type": "Class", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/AbstractColumnDefinition.html", "name": "Plasma\\AbstractColumnDefinition", "doc": "&quot;Column Definitions define columns (who would&#039;ve thought of that?). Such as their name, type, length, etc.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\AbstractColumnDefinition", "fromLink": "Plasma/AbstractColumnDefinition.html", "link": "Plasma/AbstractColumnDefinition.html#method___construct", "name": "Plasma\\AbstractColumnDefinition::__construct", "doc": "&quot;Constructor.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\AbstractColumnDefinition", "fromLink": "Plasma/AbstractColumnDefinition.html", "link": "Plasma/AbstractColumnDefinition.html#method_getDatabaseName", "name": "Plasma\\AbstractColumnDefinition::getDatabaseName", "doc": "&quot;Get the database name this column is in.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\AbstractColumnDefinition", "fromLink": "Plasma/AbstractColumnDefinition.html", "link": "Plasma/AbstractColumnDefinition.html#method_getTableName", "name": "Plasma\\AbstractColumnDefinition::getTableName", "doc": "&quot;Get the table name this column is in.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\AbstractColumnDefinition", "fromLink": "Plasma/AbstractColumnDefinition.html", "link": "Plasma/AbstractColumnDefinition.html#method_getName", "name": "Plasma\\AbstractColumnDefinition::getName", "doc": "&quot;Get the column name.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\AbstractColumnDefinition", "fromLink": "Plasma/AbstractColumnDefinition.html", "link": "Plasma/AbstractColumnDefinition.html#method_getType", "name": "Plasma\\AbstractColumnDefinition::getType", "doc": "&quot;Get the type name, such as &lt;code&gt;BIGINT&lt;\/code&gt;, &lt;code&gt;VARCHAR&lt;\/code&gt;, etc.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\AbstractColumnDefinition", "fromLink": "Plasma/AbstractColumnDefinition.html", "link": "Plasma/AbstractColumnDefinition.html#method_getCharset", "name": "Plasma\\AbstractColumnDefinition::getCharset", "doc": "&quot;Get the charset, such as &lt;code&gt;utf8mb4&lt;\/code&gt;.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\AbstractColumnDefinition", "fromLink": "Plasma/AbstractColumnDefinition.html", "link": "Plasma/AbstractColumnDefinition.html#method_getLength", "name": "Plasma\\AbstractColumnDefinition::getLength", "doc": "&quot;Get the maximum field length, if any.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\AbstractColumnDefinition", "fromLink": "Plasma/AbstractColumnDefinition.html", "link": "Plasma/AbstractColumnDefinition.html#method_getFlags", "name": "Plasma\\AbstractColumnDefinition::getFlags", "doc": "&quot;Get the column flags.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\AbstractColumnDefinition", "fromLink": "Plasma/AbstractColumnDefinition.html", "link": "Plasma/AbstractColumnDefinition.html#method_getDecimals", "name": "Plasma\\AbstractColumnDefinition::getDecimals", "doc": "&quot;Get the maximum shown decimal digits.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\AbstractColumnDefinition", "fromLink": "Plasma/AbstractColumnDefinition.html", "link": "Plasma/AbstractColumnDefinition.html#method_parseValue", "name": "Plasma\\AbstractColumnDefinition::parseValue", "doc": "&quot;Parses the row value into the field type.&quot;"},
            {"type": "Class", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/Client.html", "name": "Plasma\\Client", "doc": "&quot;The plasma client, responsible for pooling and connections.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method___construct", "name": "Plasma\\Client::__construct", "doc": "&quot;Creates a client with the specified factory and options.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_create", "name": "Plasma\\Client::create", "doc": "&quot;Creates a client with the specified factory and options.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_getConnectionCount", "name": "Plasma\\Client::getConnectionCount", "doc": "&quot;Get the amount of connections.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_checkinConnection", "name": "Plasma\\Client::checkinConnection", "doc": "&quot;Checks a connection back in, if usable and not closing.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_beginTransaction", "name": "Plasma\\Client::beginTransaction", "doc": "&quot;Begins a transaction. Resolves with a &lt;code&gt;Transaction&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_query", "name": "Plasma\\Client::query", "doc": "&quot;Executes a plain query. Resolves with a &lt;code&gt;QueryResult&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_prepare", "name": "Plasma\\Client::prepare", "doc": "&quot;Prepares a query. Resolves with a &lt;code&gt;StatementInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_execute", "name": "Plasma\\Client::execute", "doc": "&quot;Prepares and executes a query. Resolves with a &lt;code&gt;QueryResultInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_quote", "name": "Plasma\\Client::quote", "doc": "&quot;Quotes the string for use in the query.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_close", "name": "Plasma\\Client::close", "doc": "&quot;Closes all connections gracefully after processing all outstanding requests.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_quit", "name": "Plasma\\Client::quit", "doc": "&quot;Forcefully closes the connection, without waiting for any outstanding requests. This will reject all oustanding requests.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_runCommand", "name": "Plasma\\Client::runCommand", "doc": "&quot;Runs the given command.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_runQuery", "name": "Plasma\\Client::runQuery", "doc": "&quot;Runs the given querybuilder on an underlying driver instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Client", "fromLink": "Plasma/Client.html", "link": "Plasma/Client.html#method_createReadCursor", "name": "Plasma\\Client::createReadCursor", "doc": "&quot;Creates a new cursor to seek through SELECT query results.&quot;"},
            {"type": "Class", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/Exception.html", "name": "Plasma\\Exception", "doc": "&quot;The base exception for Plasma.&quot;"},
                    {"type": "Class", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/QueryResult.html", "name": "Plasma\\QueryResult", "doc": "&quot;A class representing a regular query result (no SELECT), with no event emitter.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\QueryResult", "fromLink": "Plasma/QueryResult.html", "link": "Plasma/QueryResult.html#method___construct", "name": "Plasma\\QueryResult::__construct", "doc": "&quot;Constructor.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryResult", "fromLink": "Plasma/QueryResult.html", "link": "Plasma/QueryResult.html#method_getAffectedRows", "name": "Plasma\\QueryResult::getAffectedRows", "doc": "&quot;Get the number of affected rows (for UPDATE, DELETE, etc.).&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryResult", "fromLink": "Plasma/QueryResult.html", "link": "Plasma/QueryResult.html#method_getWarningsCount", "name": "Plasma\\QueryResult::getWarningsCount", "doc": "&quot;Get the number of warnings sent by the server.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryResult", "fromLink": "Plasma/QueryResult.html", "link": "Plasma/QueryResult.html#method_getInsertID", "name": "Plasma\\QueryResult::getInsertID", "doc": "&quot;Get the used insert ID for the row, if any. &lt;code&gt;INSERT&lt;\/code&gt; statements only.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryResult", "fromLink": "Plasma/QueryResult.html", "link": "Plasma/QueryResult.html#method_getFieldDefinitions", "name": "Plasma\\QueryResult::getFieldDefinitions", "doc": "&quot;Get the field definitions, if any. &lt;code&gt;SELECT&lt;\/code&gt; statements only.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\QueryResult", "fromLink": "Plasma/QueryResult.html", "link": "Plasma/QueryResult.html#method_getRows", "name": "Plasma\\QueryResult::getRows", "doc": "&quot;Get the rows, if any. &lt;code&gt;SELECT&lt;\/code&gt; statements only.&quot;"},
            {"type": "Class", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/StreamQueryResult.html", "name": "Plasma\\StreamQueryResult", "doc": "&quot;A query result stream. Used to get rows row by row, as sent by the DBMS.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\StreamQueryResult", "fromLink": "Plasma/StreamQueryResult.html", "link": "Plasma/StreamQueryResult.html#method___construct", "name": "Plasma\\StreamQueryResult::__construct", "doc": "&quot;Constructor.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\StreamQueryResult", "fromLink": "Plasma/StreamQueryResult.html", "link": "Plasma/StreamQueryResult.html#method_getAffectedRows", "name": "Plasma\\StreamQueryResult::getAffectedRows", "doc": "&quot;Get the number of affected rows (for UPDATE, DELETE, etc.).&quot;"},
                    {"type": "Method", "fromName": "Plasma\\StreamQueryResult", "fromLink": "Plasma/StreamQueryResult.html", "link": "Plasma/StreamQueryResult.html#method_getWarningsCount", "name": "Plasma\\StreamQueryResult::getWarningsCount", "doc": "&quot;Get the number of warnings sent by the server.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\StreamQueryResult", "fromLink": "Plasma/StreamQueryResult.html", "link": "Plasma/StreamQueryResult.html#method_getInsertID", "name": "Plasma\\StreamQueryResult::getInsertID", "doc": "&quot;Get the used insert ID for the row, if any. &lt;code&gt;INSERT&lt;\/code&gt; statements only.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\StreamQueryResult", "fromLink": "Plasma/StreamQueryResult.html", "link": "Plasma/StreamQueryResult.html#method_getFieldDefinitions", "name": "Plasma\\StreamQueryResult::getFieldDefinitions", "doc": "&quot;Get the field definitions, if any. &lt;code&gt;SELECT&lt;\/code&gt; statements only.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\StreamQueryResult", "fromLink": "Plasma/StreamQueryResult.html", "link": "Plasma/StreamQueryResult.html#method_getRows", "name": "Plasma\\StreamQueryResult::getRows", "doc": "&quot;Get the rows, if any. Returns always &lt;code&gt;null&lt;\/code&gt;.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\StreamQueryResult", "fromLink": "Plasma/StreamQueryResult.html", "link": "Plasma/StreamQueryResult.html#method_all", "name": "Plasma\\StreamQueryResult::all", "doc": "&quot;Buffers all rows and returns a promise which resolves with an instance of &lt;code&gt;QueryResultInterface&lt;\/code&gt;.&quot;"},
            {"type": "Class", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/Transaction.html", "name": "Plasma\\Transaction", "doc": "&quot;Represents a transaction.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method___construct", "name": "Plasma\\Transaction::__construct", "doc": "&quot;Creates a client with the specified factory and options.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method___destruct", "name": "Plasma\\Transaction::__destruct", "doc": "&quot;Destructor. Implicit rollback and automatically checks the connection back into the client on deallocation.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_getIsolationLevel", "name": "Plasma\\Transaction::getIsolationLevel", "doc": "&quot;Get the isolation level for this transaction.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_isActive", "name": "Plasma\\Transaction::isActive", "doc": "&quot;Whether the transaction is still active, or has been committed\/rolled back.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_query", "name": "Plasma\\Transaction::query", "doc": "&quot;Executes a plain query. Resolves with a &lt;code&gt;QueryResult&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_prepare", "name": "Plasma\\Transaction::prepare", "doc": "&quot;Prepares a query. Resolves with a &lt;code&gt;StatementInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_execute", "name": "Plasma\\Transaction::execute", "doc": "&quot;Prepares and executes a query. Resolves with a &lt;code&gt;QueryResultInterface&lt;\/code&gt; instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_quote", "name": "Plasma\\Transaction::quote", "doc": "&quot;Quotes the string for use in the query.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_runQuery", "name": "Plasma\\Transaction::runQuery", "doc": "&quot;Runs the given querybuilder on the underlying driver instance.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_commit", "name": "Plasma\\Transaction::commit", "doc": "&quot;Commits the changes.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_rollback", "name": "Plasma\\Transaction::rollback", "doc": "&quot;Rolls back the changes.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_createSavepoint", "name": "Plasma\\Transaction::createSavepoint", "doc": "&quot;Creates a savepoint with the given identifier.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_rollbackTo", "name": "Plasma\\Transaction::rollbackTo", "doc": "&quot;Rolls back to the savepoint with the given identifier.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Transaction", "fromLink": "Plasma/Transaction.html", "link": "Plasma/Transaction.html#method_releaseSavepoint", "name": "Plasma\\Transaction::releaseSavepoint", "doc": "&quot;Releases the savepoint with the given identifier.&quot;"},
            {"type": "Class", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/TransactionException.html", "name": "Plasma\\TransactionException", "doc": "&quot;The exception for transaction exceptions, such as trying to use a finished transaction.&quot;"},
                    {"type": "Class", "fromName": "Plasma\\Types", "fromLink": "Plasma/Types.html", "link": "Plasma/Types/AbstractTypeExtension.html", "name": "Plasma\\Types\\AbstractTypeExtension", "doc": "&quot;An abstract type extension.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\Types\\AbstractTypeExtension", "fromLink": "Plasma/Types/AbstractTypeExtension.html", "link": "Plasma/Types/AbstractTypeExtension.html#method___construct", "name": "Plasma\\Types\\AbstractTypeExtension::__construct", "doc": "&quot;Constructor.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\AbstractTypeExtension", "fromLink": "Plasma/Types/AbstractTypeExtension.html", "link": "Plasma/Types/AbstractTypeExtension.html#method_canHandleType", "name": "Plasma\\Types\\AbstractTypeExtension::canHandleType", "doc": "&quot;Whether the type extension can handle the conversion of the passed value.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\AbstractTypeExtension", "fromLink": "Plasma/Types/AbstractTypeExtension.html", "link": "Plasma/Types/AbstractTypeExtension.html#method_getHumanType", "name": "Plasma\\Types\\AbstractTypeExtension::getHumanType", "doc": "&quot;Get the human-readable type this Type Extension is for.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\AbstractTypeExtension", "fromLink": "Plasma/Types/AbstractTypeExtension.html", "link": "Plasma/Types/AbstractTypeExtension.html#method_getDatabaseType", "name": "Plasma\\Types\\AbstractTypeExtension::getDatabaseType", "doc": "&quot;Get the database type this Type Extension is for.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\AbstractTypeExtension", "fromLink": "Plasma/Types/AbstractTypeExtension.html", "link": "Plasma/Types/AbstractTypeExtension.html#method_encode", "name": "Plasma\\Types\\AbstractTypeExtension::encode", "doc": "&quot;Encodes a PHP value into a binary database value.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\AbstractTypeExtension", "fromLink": "Plasma/Types/AbstractTypeExtension.html", "link": "Plasma/Types/AbstractTypeExtension.html#method_decode", "name": "Plasma\\Types\\AbstractTypeExtension::decode", "doc": "&quot;Decodes a binary database value into a PHP value.&quot;"},
            {"type": "Class", "fromName": "Plasma\\Types", "fromLink": "Plasma/Types.html", "link": "Plasma/Types/TypeExtensionResult.html", "name": "Plasma\\Types\\TypeExtensionResult", "doc": "&quot;Represents a successful encoding conversion.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionResult", "fromLink": "Plasma/Types/TypeExtensionResult.html", "link": "Plasma/Types/TypeExtensionResult.html#method___construct", "name": "Plasma\\Types\\TypeExtensionResult::__construct", "doc": "&quot;Constructor.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionResult", "fromLink": "Plasma/Types/TypeExtensionResult.html", "link": "Plasma/Types/TypeExtensionResult.html#method_getDatabaseType", "name": "Plasma\\Types\\TypeExtensionResult::getDatabaseType", "doc": "&quot;Get the database type.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionResult", "fromLink": "Plasma/Types/TypeExtensionResult.html", "link": "Plasma/Types/TypeExtensionResult.html#method_isUnsigned", "name": "Plasma\\Types\\TypeExtensionResult::isUnsigned", "doc": "&quot;Whether it&#039;s unsigned.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionResult", "fromLink": "Plasma/Types/TypeExtensionResult.html", "link": "Plasma/Types/TypeExtensionResult.html#method_getValue", "name": "Plasma\\Types\\TypeExtensionResult::getValue", "doc": "&quot;Get the encoded value.&quot;"},
            {"type": "Class", "fromName": "Plasma\\Types", "fromLink": "Plasma/Types.html", "link": "Plasma/Types/TypeExtensionsManager.html", "name": "Plasma\\Types\\TypeExtensionsManager", "doc": "&quot;The Type Extension Manager manages type extensions globally.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionsManager", "fromLink": "Plasma/Types/TypeExtensionsManager.html", "link": "Plasma/Types/TypeExtensionsManager.html#method_getManager", "name": "Plasma\\Types\\TypeExtensionsManager::getManager", "doc": "&quot;Get a specific Type Extensions Manager under a specific name.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionsManager", "fromLink": "Plasma/Types/TypeExtensionsManager.html", "link": "Plasma/Types/TypeExtensionsManager.html#method_registerManager", "name": "Plasma\\Types\\TypeExtensionsManager::registerManager", "doc": "&quot;Registers a specific Type Extensions Manager under a specific name.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionsManager", "fromLink": "Plasma/Types/TypeExtensionsManager.html", "link": "Plasma/Types/TypeExtensionsManager.html#method_unregisterManager", "name": "Plasma\\Types\\TypeExtensionsManager::unregisterManager", "doc": "&quot;Unregisters a name. If the name does not exist, this will do nothing.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionsManager", "fromLink": "Plasma/Types/TypeExtensionsManager.html", "link": "Plasma/Types/TypeExtensionsManager.html#method_registerType", "name": "Plasma\\Types\\TypeExtensionsManager::registerType", "doc": "&quot;Registers a type.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionsManager", "fromLink": "Plasma/Types/TypeExtensionsManager.html", "link": "Plasma/Types/TypeExtensionsManager.html#method_unregisterType", "name": "Plasma\\Types\\TypeExtensionsManager::unregisterType", "doc": "&quot;Unregisters a type. A non-existent type identifier does nothing.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionsManager", "fromLink": "Plasma/Types/TypeExtensionsManager.html", "link": "Plasma/Types/TypeExtensionsManager.html#method_registerDatabaseType", "name": "Plasma\\Types\\TypeExtensionsManager::registerDatabaseType", "doc": "&quot;Registers a type.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionsManager", "fromLink": "Plasma/Types/TypeExtensionsManager.html", "link": "Plasma/Types/TypeExtensionsManager.html#method_unregisterDatabaseType", "name": "Plasma\\Types\\TypeExtensionsManager::unregisterDatabaseType", "doc": "&quot;Unregisters a Database type. A non-existent type identifier does nothing.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionsManager", "fromLink": "Plasma/Types/TypeExtensionsManager.html", "link": "Plasma/Types/TypeExtensionsManager.html#method_enableFuzzySearch", "name": "Plasma\\Types\\TypeExtensionsManager::enableFuzzySearch", "doc": "&quot;Enables iterating over all types and invoking &lt;code&gt;canHandleType&lt;\/code&gt;, if quick type check is failing.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionsManager", "fromLink": "Plasma/Types/TypeExtensionsManager.html", "link": "Plasma/Types/TypeExtensionsManager.html#method_disableFuzzySearch", "name": "Plasma\\Types\\TypeExtensionsManager::disableFuzzySearch", "doc": "&quot;Disables iterating over all types and invoking &lt;code&gt;canHandleType&lt;\/code&gt;, if quick type check is failing.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionsManager", "fromLink": "Plasma/Types/TypeExtensionsManager.html", "link": "Plasma/Types/TypeExtensionsManager.html#method_encodeType", "name": "Plasma\\Types\\TypeExtensionsManager::encodeType", "doc": "&quot;Tries to encode a value.&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Types\\TypeExtensionsManager", "fromLink": "Plasma/Types/TypeExtensionsManager.html", "link": "Plasma/Types/TypeExtensionsManager.html#method_decodeType", "name": "Plasma\\Types\\TypeExtensionsManager::decodeType", "doc": "&quot;Tries to decode a value.&quot;"},
            {"type": "Class", "fromName": "Plasma", "fromLink": "Plasma.html", "link": "Plasma/Utility.html", "name": "Plasma\\Utility", "doc": "&quot;Common utilities for components.&quot;"},
                                                        {"type": "Method", "fromName": "Plasma\\Utility", "fromLink": "Plasma/Utility.html", "link": "Plasma/Utility.html#method_parseParameters", "name": "Plasma\\Utility::parseParameters", "doc": "&quot;Parses a query containing parameters into an array, and can replace them with a predefined replacement (can be a callable).&quot;"},
                    {"type": "Method", "fromName": "Plasma\\Utility", "fromLink": "Plasma/Utility.html", "link": "Plasma/Utility.html#method_replaceParameters", "name": "Plasma\\Utility::replaceParameters", "doc": "&quot;Replaces the user parameters keys with the correct parameters for the DBMS.&quot;"},
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


