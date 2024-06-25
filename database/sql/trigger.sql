-- Trigger untuk mengupdate stok_terjual setelah insert
CREATE TRIGGER update_stok_voucher_terjual AFTER INSERT ON voucher
FOR EACH ROW
BEGIN
    IF NEW.status_voucher = 'Terjual' THEN
        UPDATE jenis_voucher
        SET stok_terjual = stok_terjual + 1
        WHERE id = NEW.id_jenis;
    END IF;
END;

-- Trigger untuk mengupdate stok_terjual setelah update
CREATE TRIGGER update_stok_voucher_terjual_after_update AFTER UPDATE ON voucher
FOR EACH ROW
BEGIN
    IF NEW.status_voucher != OLD.status_voucher AND OLD.status_voucher = 'Terjual' THEN
        UPDATE jenis_voucher
        SET stok_terjual = stok_terjual - 1
        WHERE id = NEW.id_jenis;
    ELSEIF NEW.status_voucher != OLD.status_voucher AND NEW.status_voucher = 'Terjual' THEN
        UPDATE jenis_voucher
        SET stok_terjual = stok_terjual + 1
        WHERE id = NEW.id_jenis;
    END IF;
END;

-- Trigger untuk mengupdate stok_tersedia setelah insert
CREATE TRIGGER update_stok_voucher_tersedia AFTER INSERT ON voucher
FOR EACH ROW
BEGIN
    IF NEW.status_voucher = 'Tersedia' THEN
        SET @totalVoucherTersedia = 0;
        SELECT COUNT(*) INTO @totalVoucherTersedia
        FROM voucher
        WHERE id_jenis = NEW.id_jenis AND status_voucher = 'Tersedia';

        UPDATE jenis_voucher
        SET stok_tersedia = @totalVoucherTersedia
        WHERE id = NEW.id_jenis;
    END IF;
END;

-- Trigger untuk mengupdate stok_tersedia setelah update
CREATE TRIGGER update_stok_voucher_tersedia_after_update AFTER UPDATE ON voucher
FOR EACH ROW
BEGIN
    IF NEW.status_voucher != OLD.status_voucher AND OLD.status_voucher = 'Tersedia' THEN
        SET @totalVoucherTersedia = 0;
        SELECT COUNT(*) INTO @totalVoucherTersedia
        FROM voucher
        WHERE id_jenis = NEW.id_jenis AND status_voucher = 'Tersedia';

        UPDATE jenis_voucher
        SET stok_tersedia = @totalVoucherTersedia
        WHERE id = NEW.id_jenis;
    ELSEIF NEW.status_voucher != OLD.status_voucher AND NEW.status_voucher = 'Tersedia' THEN
        SET @totalVoucherTersedia = 0;
        SELECT COUNT(*) INTO @totalVoucherTersedia
        FROM voucher
        WHERE id_jenis = NEW.id_jenis AND status_voucher = 'Tersedia';

        UPDATE jenis_voucher
        SET stok_tersedia = @totalVoucherTersedia
        WHERE id = NEW.id_jenis;
    END IF;
END;
