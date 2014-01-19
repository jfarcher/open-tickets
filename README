PHP Based ticketing/helpdesk system.
I half created this a long time ago and am only just getting around to publishing the code.

This code probably won't work out of the box for you... Yet.



TODO:
functions:

open ticket:

close ticket:

messages:

ticket status:

assignment:

customer view:
for main external website.

create a client to phonebook link
client table contains clients holding support contracts(or at least will do, for now a list of clients within tickets system) this uses phonebook for lookup only. phonebook contains new field(or new table to link) client_id/contract_id to email addresses.

tickets_contact details table: will give details of who raised the ticket.

so email process will be: email -> check sender -> match sender email to phonebook -> match phonebook id to clients/contracts table to get contract id -> store contract id, ticket number and phonebook id in table.
Possibility to have additional contacts field to allow others to recieve updates on tickets. - future
create functions to do all this?

ticket creation via email:
check sender is in client db, if is create ticket and response
if not, send non customer response, log ticket with non customer priority, notify group
create ticket done - to be else of above
--needs to be fixed with changes in php-imap

ticket updates via email:
check sender is in contracts table, if is procede, if not log ticket, notify group, send modified email for updates - pending contracts table
check for ticket number in email - done
if number is valid ticket number create update, upon update creation send an email to confirm update was recieved and details of update/ticket done
if number is not valid, create a ticket - reformatting the subject line, send an email to confirm new ticket but with details that its a new ticket and there was a problem done





close ticket
my assigned tickets
email collection - in progress - collection working fine now.
email response on message creation, better response on ticket creation and update, creation is ok but needs work, update is pretty poor and only works if an update is via email.



forms - form in development, requires bit of tinkering for auto-complete/auto-populate


-----future-----
tidy up - a long way off! found a potential theme though

replace frames with divs? - part of transition to theme, need to get functionality sorted first
prefs/settings page - think this is probably a version 2 or maybe version 3 feature
change all mysql to use $db->this type statements - worth it? doubt this is worth it
convert functions to use OOP - hmm version 10?

message tidy up for storage and display - seems to be working pretty well, just need to work on getting the display to look better, fonts are cack at the minute and the table layout probably isn't the best idea, will look at using divs which would probably give a nicer feel to the layout.



