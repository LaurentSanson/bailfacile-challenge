<?php

namespace App\DataFixtures;

use App\Entity\Document;
use App\Entity\DocumentType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $rentalAgreement = new DocumentType();
        $rentalAgreement->setName('Rental Agreement');
        $rentalAgreement->setSlug('rental_agreement');
        $rentalAgreement->setFormat('contract');
        $rentalAgreement->setCanBeESign(true);
        $rentalAgreement->setCanBeSendByMail(true);
        $rentalAgreement->setCanBeSendByPost(false);
        $rentalAgreement->setCanBeUpdated(true);
        $manager->persist($rentalAgreement);

        for ($i = 0; $i < 8; ++$i) {
            $document = new Document();
            $document->setDocumentType($rentalAgreement);
            $document->setUser($manager->getRepository(User::class)->findOneBy([]));
            $manager->persist($document);
        }

        $rentalGuaranteeAgreement = new DocumentType();
        $rentalGuaranteeAgreement->setName('Rental Guarantee Agreement');
        $rentalGuaranteeAgreement->setSlug('rental_guarantee_agreement');
        $rentalGuaranteeAgreement->setFormat('contract');
        $rentalGuaranteeAgreement->setCanBeESign(true);
        $rentalGuaranteeAgreement->setCanBeSendByMail(true);
        $rentalGuaranteeAgreement->setCanBeSendByPost(false);
        $rentalGuaranteeAgreement->setCanBeUpdated(true);
        $manager->persist($rentalGuaranteeAgreement);

        for ($i = 0; $i < 8; ++$i) {
            $document = new Document();
            $document->setDocumentType($rentalGuaranteeAgreement);
            $document->setUser($manager->getRepository(User::class)->findOneBy([]));
            $manager->persist($document);
        }

        $subLettingAgreement = new DocumentType();
        $subLettingAgreement->setName('Sub-letting Agreement');
        $subLettingAgreement->setSlug('subletting_agreement');
        $subLettingAgreement->setFormat('contract');
        $subLettingAgreement->setCanBeESign(true);
        $subLettingAgreement->setCanBeSendByMail(true);
        $subLettingAgreement->setCanBeSendByPost(false);
        $subLettingAgreement->setCanBeUpdated(true);
        $manager->persist($subLettingAgreement);

        for ($i = 0; $i < 8; ++$i) {
            $document = new Document();
            $document->setDocumentType($subLettingAgreement);
            $document->setUser($manager->getRepository(User::class)->findOneBy([]));
            $manager->persist($document);
        }

        $rentalAgreementAmendment = new DocumentType();
        $rentalAgreementAmendment->setName('Rental Agreement Amendment');
        $rentalAgreementAmendment->setSlug('rental_agreement_amendment');
        $rentalAgreementAmendment->setFormat('contract');
        $rentalAgreementAmendment->setCanBeESign(true);
        $rentalAgreementAmendment->setCanBeSendByMail(true);
        $rentalAgreementAmendment->setCanBeSendByPost(false);
        $rentalAgreementAmendment->setCanBeUpdated(true);
        $manager->persist($rentalAgreementAmendment);

        for ($i = 0; $i < 8; ++$i) {
            $document = new Document();
            $document->setDocumentType($rentalAgreementAmendment);
            $document->setUser($manager->getRepository(User::class)->findOneBy([]));
            $manager->persist($document);
        }

        $rentReceipt = new DocumentType();
        $rentReceipt->setName('Rent Receipt');
        $rentReceipt->setSlug('rent_receipt');
        $rentReceipt->setFormat('letter');
        $rentReceipt->setCanBeESign(false);
        $rentReceipt->setCanBeSendByMail(true);
        $rentReceipt->setCanBeSendByPost(true);
        $rentReceipt->setCanBeUpdated(true);
        $manager->persist($rentReceipt);

        for ($i = 0; $i < 8; ++$i) {
            $document = new Document();
            $document->setDocumentType($rentReceipt);
            $document->setUser($manager->getRepository(User::class)->findOneBy([]));
            $manager->persist($document);
        }

        $rentInvoice = new DocumentType();
        $rentInvoice->setName('Rent Invoice');
        $rentInvoice->setSlug('rent_invoice');
        $rentInvoice->setFormat('letter');
        $rentInvoice->setCanBeESign(false);
        $rentInvoice->setCanBeSendByMail(true);
        $rentInvoice->setCanBeSendByPost(true);
        $rentInvoice->setCanBeUpdated(true);
        $manager->persist($rentInvoice);

        for ($i = 0; $i < 8; ++$i) {
            $document = new Document();
            $document->setDocumentType($rentInvoice);
            $document->setUser($manager->getRepository(User::class)->findOneBy([]));
            $manager->persist($document);
        }

        $latePaymentLetter = new DocumentType();
        $latePaymentLetter->setName('Late Payment Letter');
        $latePaymentLetter->setSlug('late_payment_letter');
        $latePaymentLetter->setFormat('letter');
        $latePaymentLetter->setCanBeESign(false);
        $latePaymentLetter->setCanBeSendByMail(true);
        $latePaymentLetter->setCanBeSendByPost(true);
        $latePaymentLetter->setCanBeUpdated(true);
        $manager->persist($latePaymentLetter);

        for ($i = 0; $i < 8; ++$i) {
            $document = new Document();
            $document->setDocumentType($latePaymentLetter);
            $document->setUser($manager->getRepository(User::class)->findOneBy([]));
            $manager->persist($document);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
