BEGIN TRANSACTION;
DROP TABLE IF EXISTS "Accounts";
CREATE TABLE IF NOT EXISTS "Accounts" (
	"AccountID"	INTEGER NOT NULL,
	"Login"	TEXT NOT NULL,
	"Password"	TEXT NOT NULL,
	"Selected"	INTEGER NOT NULL,
	"Created"	INTEGER NOT NULL,
	"LastLogin"	INTEGER NOT NULL,
	PRIMARY KEY("AccountID" AUTOINCREMENT)
);
COMMIT;
