# SQL-Connection
A php script to manage mysql server through http POST request.

##### requestType = "select", "update", " ~~alter~~", "insert".

select: SELECT \[col] FROM \[table] WHERE \[key] = \[value]

update: UPDATE \[table] SET \[col] WHERE \[colWhere] = \[valueWhere]

insert: INSERT INTO \[table] (keys) VALUES ([values])


### UPDATE:

/index.php?requestType=**update**&col=**CLASS**&value=**VALUE**&table=**TABLE**&colWhere=**ID**&valueWhere=**52**

### SELECT:

/index.php?requestType=**select**&col=**class**&table=**TABLE**&key=**ID**&value=**5**

### INSERT:

/index.php?requestType=insert&table=**TABLE**&key=**CLASS,ID,user**&value=**"class5","55","nipo"**
