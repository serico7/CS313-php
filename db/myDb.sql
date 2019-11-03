CREATE table works(
	workid serial NOT NULL PRIMARY KEY,
	name varchar(63) NOT NULL
);

CREATE table characters(
	charid serial NOT NULL PRIMARY KEY,
	name varchar(31) NOT NULL,
	art varchar(255) NOT NULL
);

CREATE table worktocharacter(
	workid integer NOT NULL references works(workid),
	charid integer NOT NULL references characters(charid)
);

CREATE table persons(
	userid serial NOT NULL PRIMARY KEY,
	username varchar(31) NOT NULL UNIQUE,
	password varchar(31) NOT NULL
);

CREATE table selectedworks(
	userid integer NOT NULL references persons(userid),
	workid integer NOT NULL references works(workid),
	isIncluded boolean NOT NULL
);

CREATE table rankedchars(
	userid integer NOT NULL references persons(userid),
	charid integer NOT NULL references characters(charid),
	isIncluded boolean NOT NULL,
	userRank integer
);