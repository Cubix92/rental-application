<?php

namespace Rental\Application\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Rental\Domain\Booking\BookingRepository;
use Rental\Domain\Booking\BookingDay;
use Rental\Domain\Hotel\HotelRepository;
use Rental\Domain\Hotel\HotelRoomRepository;
use Rental\Domain\Hotel\HotelRoomFactory;

class HotelRoomService
{
    private HotelRoomRepository $hotelRoomRepository;

    private HotelRepository $hotelRepository;

    private BookingRepository $bookingRepository;

    public function __construct(
        HotelRoomRepository $hotelRoomRepository,
        HotelRepository $hotelRepository,
        BookingRepository $bookingRepository
    ) {
        $this->hotelRoomRepository = $hotelRoomRepository;
        $this->hotelRepository = $hotelRepository;
        $this->bookingRepository = $bookingRepository;
    }

    public function add(
        string $hotelId,
        int $number,
        string $description,
        array $spaces
    ): void {
        $hotel = $this->hotelRepository->findOneById($hotelId);
        $hotelRoom = (new HotelRoomFactory)->create(
            $hotel,
            $number,
            $description,
            $spaces
        );

        $this->hotelRoomRepository->save($hotelRoom);
    }

    public function book(string $id, string $tenantId, array $days): void
    {
        $hotelRoom = $this->hotelRoomRepository->findOneById($id);
        $days = array_map(function (string $day) {
            $period[] = new BookingDay($day);
        }, $days);

        $booking = $hotelRoom->book($tenantId, new ArrayCollection($days));
        $this->bookingRepository->save($booking);
    }
}