<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Analyse Entity Sentiment
 */

# [START language_entity_sentiment_text]
//use Google\ApiCore\ApiException;
//use Google\Cloud\Language\V1\Document;
//use Google\Cloud\Language\V1\Document\Type;
//use Google\Cloud\Language\V1\LanguageServiceClient;
//use Google\Cloud\Language\V1\Entity\Type as EntityType;

// $text = 'Text to analyze';
//$languageServiceClient = new LanguageServiceClient();
//try {
//    // Create a new Document, add text as content and set type to PLAIN_TEXT
//    $document = (new Document())
//        ->setContent($text)
//        ->setType(Type::PLAIN_TEXT);
//
//    // Call the analyzeEntitySentiment function
//    $response = $languageServiceClient->analyzeEntitySentiment($document);
//    $entities = $response->getEntities();
//    // Print out information about each entity
//    foreach ($entities as $entity) {
//        printf('Entity Name: %s' . PHP_EOL, $entity->getName());
//        printf('Entity Type: %s' . PHP_EOL, EntityType::name($entity->getType()));
//        printf('Entity Salience: %s' . PHP_EOL, $entity->getSalience());
//        $sentiment = $entity->getSentiment();
//        if ($sentiment) {
//            printf('Entity Magnitude: %s' . PHP_EOL, $sentiment->getMagnitude());
//            printf('Entity Score: %s' . PHP_EOL, $sentiment->getScore());
//        }
//        print(PHP_EOL);
//    }
//} catch (ApiException $e) {
//} finally {
//    $languageServiceClient->close();
//}
//# [END language_entity_sentiment_text]

/**
 * Analyse Sentiment
 */

//# [START language_sentiment_text]
//use Google\ApiCore\ApiException;
//use Google\Cloud\Language\V1\Document;
//use Google\Cloud\Language\V1\Document\Type;
//use Google\Cloud\Language\V1\LanguageServiceClient;
//
///** Uncomment and populate these variables in your code */
//$text = 'Text to analyze';
//
//$languageServiceClient = new LanguageServiceClient();
//try {
//    // Create a new Document, add text as content and set type to PLAIN_TEXT
//    $document = (new Document())
//        ->setContent($text)
//        ->setType(Type::PLAIN_TEXT);
//
//    // Call the analyzeSentiment function
//    $response = $languageServiceClient->analyzeSentiment($document);
//    $document_sentiment = $response->getDocumentSentiment();
//    // Print document information
//    printf('Document Sentiment: %s' . PHP_EOL, $document_sentiment->getScore());
//    printf('  Magnitude: %s' . PHP_EOL, $document_sentiment->getMagnitude());
//    printf('  Score: %s' . PHP_EOL, $document_sentiment->getScore());
//    printf(PHP_EOL);
//    $sentences = $response->getSentences();
//    foreach ($sentences as $sentence) {
//        printf('Sentence: %s' . PHP_EOL, $sentence->getText()->getContent());
//        printf('Sentence Sentiment:' . PHP_EOL);
//        $sentiment = $sentence->getSentiment();
//        if ($sentiment) {
//            printf('Entity Magnitude: %s' . PHP_EOL, $sentiment->getMagnitude());
//            printf('Entity Score: %s' . PHP_EOL, $sentiment->getScore());
//        }
//        print(PHP_EOL);
//    }
//} catch (ApiException $e) {
//    print("Something went wrong:\n");
//} finally {
//    $languageServiceClient->close();
//}
//# [END language_sentiment_text]


# [START analyze_all]
use Google\Cloud\Language\V1\AnnotateTextRequest\Features;
use Google\Cloud\Language\V1\Document;
use Google\Cloud\Language\V1\Document\Type;
use Google\Cloud\Language\V1\LanguageServiceClient;
use Google\Cloud\Language\V1\Entity\Type as EntityType;
use Google\Cloud\Language\V1\EntityMention\Type as MentionType;
use Google\Cloud\Language\V1\PartOfSpeech\Tag;

/** Uncomment and populate these variables in your code */
// $text = 'The text to analyze.';
//$text = "This movie was very good, not great but very good. It is based on a one man play by Ruben Santiago Hudson..yes he played most of the parts. On paper it looks like stunt casting. Yes let's round up all the black folks in Hollywood and put them in one movie. Halle Berry even produced it. The only name I didn't see was Oprah's ,thank god because it probably would of ended up being like a Hallmark movie. Instead this movie was not some sentimental mess. It was moving but not phony, the characters came and went with the exception of her husband, Pauline and the writer in question. The movie revolved around the universe of Nanny, Mrs Bill Crosby and how she raised the writer and took in people. Now being a jaded New Yorker when he said she took in sick people and old and then we see them going to a mental institution to pick up a man, I'm thinking looks like sister has a medicare scam going. Getting folks jobs and taking the medicare/caid checks But no she explains to Lou Gosset she just wants 25 bucks a week and did not want the money ahead of time. I think that part was put in the movie just for us jaded New Yorkers so we know she is not scamming the poor folks.(g) It was written by a New Yorker so he knows the deal(g).. She almost seems angelic and looking through a little boys eyes I can see why. She is married to a ne'er do well who is 17 years younger and fools around on her. Terrence Howard was born to play these type of parts. He was good but I would like to see him play something different. Markerson who plays Nanny is also very good. But for some reason the person who stood out to me was a small role played by Jeffery Wright. Where is this mans Oscar? He already won a Emmy and a Tony. He was in Shaft and he stole the movie. I did not even know who he was in this movie. He is a chameleon never the same. I never seen him play a bad part yet. This was a 5 minute role and he managed to make me both laugh and cry. I re-winded the scene few times ..one time because I didn't know who he was. His wife Carman Ejogo was excellent. I have seen her in roles before mostly mousy stuff. But she is so good here. I actually know people who act just like her. So it was very real to me Macy Grey who had one of the bigger parts was also very good. I was very happy that they did not kill Nanny off. I thought she was a goner in the beginning of the movie. BUT she was able to go home and start her old routine of taking care of people. There are women like that in most of our lives. People we might know or even lived with. Thank god for them, I do not know how they do it all of the time. I have a friend who lost 2 children and been through a lot of stuff but whenever I am feeling selfishly sorry for myself I call her and she always puts me in a good mood. THis movie is a tribute to all of those people. I only wish they they told us what happened to some of the characters like the the one armed man, Paulines boyfriend who is played by one of my favorite actors on HBO's The Wire, Omar, Rosie Perez's character and Richard the lesbian and Delroy Lindo's one arm man, he was mesmerizing in another small role.";
//$text = "1956 was the 20th Congress of the Communist Party and the Soviet Premier Krushchev made a speech denouncing Stalin and the Stalinist purges and the gulag labor systems, revealing information that was previously forbidden, publicly revealing horrible new truths, which opened the door for a new Soviet Cinema led by Mikhail Kalatozov, once Stalin's head of film production. This film features a Red Army that is NOT victorious, in fact they are encircled, in a retreat mode, with many people dying, including the hero, in a film set after 06-02-41, the German invasion of Russia when Germany introduced the Barbarossa Plan, a blitzkrieg invasion intended to bring about a quick victory and the ultimate enslavement of the Slavs, and very nearly succeeded, actually getting within 20 miles of Moscow in what was a Red Army wipe out, a devastation of human losses, 15 to 20 million Russians died, or 20% of the entire population. Historically, this was a moment of great trauma and suffering, a psychological shock to the Russian people, but the Red Army held and prolonged the war 4 more years until they were ultimately victorious. <br /><br />During the war, Stalin used the war genre in films for obvious morale boosting, introducing female heroines who were ultra-patriotic and strong and idealistic, suggesting that if females could be so successful and patriotic, then Russia could expect at least as much from their soldiers. Stalin eliminated the mass hero of the proletariat and replaced it with an individual, bold leader who was successful at killing many of the enemy, an obvious reference to Stalin himself, who was always portrayed in film as a bold, wise and victorious leader. But Kalatozov changed this depiction, as THE CRANES ARE FLYING was made after Stalin's death, causing a political thaw and creating a worldwide sensation, winning the Cannes Film Festival Palm D'Or, as well as the Best Director and Best Actress (Tatyana Samoilova), reawakening the West to Soviet Cinema for the first time since Eisenstein's IVAN THE TERRIBLE in the 40's. <br /><br />This film featured brilliant, breathtaking, and extremely mobile camera work from his extraordinary cinematographer Sergei Uresevsky, using spectacular crane and tracking shots, images of wartime, battlefields, Moscow and crowded streets that are extremely vivid and real. Another brilliant scene features the lead heroine, Veronica, who hasn't heard from her lover, Boris, in the 4 years at war, so he is presumed dead, but she continues to love him, expressed in a scene where she runs towards a bridge with a train following behind her, a moment when the viewer was wondering if she might throw herself in front of that train, instead she saves a 3 yr old boy named Boris who was about to be hit by a car. Another scene captures the death of Boris on the battlefield, who dies a senseless death, and his thoughts spin and whirl in a beautiful montage of trees, sky, leaves, all spinning in a kaleidoscope of his own thoughts and dreams, including an imaginary wedding with Veronica. This film features the famous line, \"You can dream when the war is over.\" In the final sequence, when the war is over, the soldiers are returning in a mass scene on the streets, Veronica learns Boris died, all are happy and excited with the soldier's return, but Veronica is in despair, passing out flowers to soldiers and strangers on the street in an extreme gesture of generosity and selflessness revealing \"cranes white and gray floating in the sky.\" The film was released in 1957 in Russia, and according to some reviews, \"the silence in the theater was profound, the wall between art and living life had fallen...and tears unlocked the doors.\"";
//$text = "I'm currently slogging through Gibbon's 'Fall and Decline of the Roman Empire , so I've had all things Roman on my mind. I'm not very far into it yet, maybe two hundred plus pages, but it is amazing just how many of these Roman emperors were killed. I believe I've read through maybe 15 emperors so far and only Antonius, Trajan, and Hadrian haven't been killed or at least suspected of having been killed. I have also been fascinated by the mad excesses of many of these princes of Rome. Not the least practitioner of these was Caligula. This brings me to reviewing this film. I'm thinking of the film on a historical basis as far as I understand it from Gibbon's explanation of Rome,as well as other research from some good web sites and some fiction novels dealings with the period.<br /><br />My point is I do not think that this film is what it is thought to be by many of it's proponents. I do not think the depravity shown with the sex and horrendous violence of this film qualify it as accurate. The general ideas of the film seem accurate. Caligula is raised on an island ,exiled with his family and in content fear of being murdered by the increasingly mad, suspicious and strange emperor Tiberius. He grows up paranoid and afraid and can never shake the cutesy nickname given him by his guards, Little Boots, this helps him grow up feeling abused and powerless. He is handed the empire after Tiberius dies, the senate hoping he will steer away from the informer squads which brought death by whim of the former delusionally paranoid tyrant, and lead Rome away from the madness that dictator had settled it into. Caligula begins as a decent if hands-off emperor, but gets sick, almost dies, and comes back from the brink of feverous death a true monster. His perversities with his sisters do begin here, if not before. He does have Macro killed and many others who were his originally supporters. The acts of madness seemed not to be the murders of Caligula as much as his new thinking of himself as a living God. Him seen talking to the statue of Jupiter as an equal doomed him. His violent mad excesses would have doomed him anyway, and three years seems to have been quite a decent run for the successors of Tiberius. Well the film basically sticks to these lines while it manages to be coherent, which is not common through it's entirety, it does so while trying to shock the audience at all turns, in every single scene the film begs you to be disgusted by the depravity of ancient Rome. The shocking scenes are what this film is built entirely upon and where it entirely fails. It is just too much to see successive rulers have man after man murdered, raped, tortured for no reason but fancy. The depictions of the violence are possibly, but not probably, accurate. Murder certainly was the order of the day in Imperial Rome, torture beforehand was rote. But the director's visions of these deaths and the bored amusement of their protagonists, while the bystanders watch with nonchalance, I just don't see it having gone down exactly like that. The death machine, the beheader, is certainly something like you've never seen in movies, and something once seen you shall probably never forget, even as I, you wish you could. The wine drinking while the penis is roped off is the same, once you've seen this shame it is yours forever. These things strike me the director's and that porn magnate's fantasies. They sprung from their sick imaginations and not from any proved record.<br /><br />The acting is pretty good. I actually think Mcdowell is the weakest link here. Mirren is always something to behold, and here in her youthful years she is formidable and beautiful. The portrayals of Nerva and Tiberius are done very well by their respected actors. The film could have done so much better story telling, it is such a failure that way its just a whole other layer of what a shame this thing was. For example it could have given opinion on how and why Caligula went mad, or shown that he was mad, paranoid before his illness and that fever then broke the mental restraint he had possessed previously. It could have shown the weakness of Claudius and the miracle it was he survived Caligula. It could have these and many other things but it stuck to it's sad nightmares.<br /><br />Finally about the sex. It is porn. It shows these sex acts being done all over the palaces by many people. Male on male, female on female, male on female. It is passionless, disgusting sex. Sex that if your point is to get off on it, I seriously doubt you could. Both Tiberius and Caligula may have been sex addicts, and orgies may have been common enough but the visions in this film seem to recall more a Greek time than a Roman. I don't think that kind of acceptance of homosexuality or orgies right out in the open were common until the the strange, depraved reign of Elgabalus, and he was killed for it.<br /><br />This film should probably never be watched, if your curious about it , let it go. It is something, as I said earlier, if you do watch this you will unfortunately retain it's sick visions in your minds eye for years to come. I don't think its an accurate historical picture in particular, even if it is historical in whole.";
$text = "If it turns out that there is a God, I don't think that he's evil, but the worst that you can say about him is that basically he's an underachiever.

I was on the street. This guy waved to me, and he came up to me and said, \"I'm sorry, I thought you were someone else.\" And I said, \"I am.\"

Every gay guys GPS system would tell him to Go straight.

What's a pirate minus the ship? just a creative homeless guy.

The Miss Universe pageant is fixed, All the winners are from Earth.

Without the beat in the background, Jazz basically sounds like an armadillo was let loose on the keyboard

I bought some batteries, but they weren't included.

Crystal meth's a good drug if you need to walk to St. Louis one weekend.

I got a chain letter by fax, It's very simple, You just fax a dollar bill to everybody on the list.

I called the hotel operator and she said, \"How can I direct your call?\" I said, \"Well, you could say 'Action!', and I'll begin to dial. And when I say 'Goodbye', then you can yell 'Cut!'\"

When you have a fat friend there are no see-saws, only catapults.

I rang up a local building firm, I said 'I want a skip outside my house.' He said 'I'm not stopping you.'

Two fish in a tank, one says to the other - you drive I'll man the guns.

My drinking team has a bowling problem.

To steal ideas from one person is plagiarism, To steal from many is research.

I saw a want ad - \"light housekeeping\" They said \"Here, change this bulb\" I said \"I'll need some friends\"

When they were naming the animals, somebody got lazy: anteater? What's it doing? It's eating ants, DONE!";


// Create the Natural Language client
$languageServiceClient = new LanguageServiceClient();

try {
    // Create a new Document, pass text and set type to PLAIN_TEXT
    $document = (new Document())
        ->setContent($text)
        ->setType(Type::PLAIN_TEXT);

    // Set Features to extract ['entities', 'syntax', 'sentiment']
    $features = (new Features())
        ->setExtractEntities(true)
        ->setExtractSyntax(true)
        ->setExtractDocumentSentiment(true);

    // Collect annotations
    $response = $languageServiceClient->annotateText($document, $features);

    // Process Entities
//    $entities = $response->getEntities();
//    foreach ($entities as $entity) {
//        printf('Name: %s' . PHP_EOL, $entity->getName());
//        printf('Type: %s' . PHP_EOL, EntityType::name($entity->getType()));
//        printf('Salience: %s' . PHP_EOL, $entity->getSalience());
//        if ($entity->getMetadata()->offsetExists('wikipedia_url')) {
//            printf('Wikipedia URL: %s' . PHP_EOL, $entity->getMetadata()->offsetGet('wikipedia_url'));
//        }
//        if ($entity->getMetadata()->offsetExists('mid')) {
//            printf('Knowledge Graph MID: %s' . PHP_EOL, $entity->getMetadata()->offsetGet('mid'));
//        }
//        printf('Mentions:' . PHP_EOL);
//        foreach ($entity->getMentions() as $mention) {
//            printf('  Begin Offset: %s' . PHP_EOL, $mention->getText()->getBeginOffset());
//            printf('  Content: %s' . PHP_EOL, $mention->getText()->getContent());
//            printf('  Mention Type: %s' . PHP_EOL, MentionType::name($mention->getType()));
//            printf(PHP_EOL);
//        }
//        printf(PHP_EOL);
//    }
    // Process Sentiment
    $document_sentiment = $response->getDocumentSentiment();
    printf('Section: %s' . PHP_EOL . PHP_EOL, 'Document Sentiment:');
    // Print document information
    printf('Document Sentiment:' . PHP_EOL);
    printf('  Magnitude: %s' . PHP_EOL, $document_sentiment->getMagnitude());
    printf('  Score: %s' . PHP_EOL, $document_sentiment->getScore());
    printf(PHP_EOL);
    $sentences = $response->getSentences();
    foreach ($sentences as $sentence) {
        printf('Sentence: %s' . PHP_EOL, $sentence->getText()->getContent());
        printf('Sentence Sentiment:' . PHP_EOL);
        $sentiment = $sentence->getSentiment();
        if ($sentiment) {
            printf('Entity Magnitude: %s' . PHP_EOL, $sentiment->getMagnitude());
            printf('Entity Score: %s' . PHP_EOL, $sentiment->getScore());
        }
        printf(PHP_EOL);
    }
    // Process Syntax
//    $tokens = $response->getTokens();
//    printf('Section: %s' . PHP_EOL . PHP_EOL, 'Tokens/Keywords in the document:');
//    // Print out information about each entity
//    foreach ($tokens as $token) {
//        printf('Token text: %s' . PHP_EOL, $token->getText()->getContent());
//        printf('Token part of speech: %s' . PHP_EOL, Tag::name($token->getPartOfSpeech()->getTag()));
//        printf(PHP_EOL);
//    }
} finally {
    $languageServiceClient->close();
}
# [END analyze_all]